<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rentable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Geocoder\Facades\Geocoder;

class RentablesController extends Controller
{
    public function create(){
        return view('rentables.create'); 
    }

     public function store(Request $request){
        // dd($request->all());
        $formFields = $request->validate([
            'user_id'=>'required',
            'rental_title'=>'required',
            'rental_duration'=>'required',
            'rental_charging'=> 'required',
            'negotiable'=> 'required',
            'condition'=>'required',
            'category'=>'required',
            'tags'=>'required',
            'description'=>'required',
            'image_uploads'=>'required',
            'street'=>'required',
            'city'=>'required',
            'state'=>'required',
            'country'=>'required',
            'postcode'=>'required',
            // 'latitude' => 'required_without:street',
            // 'longitude' =>'required_without:street',
            'apartment_floor'=>'nullable'
        ]);
        $formFields['user_id']=auth()->id();
        foreach ($request->file('image_uploads') as $file) {
            $path = $file->store('rentables','s3');
            \Storage::disk('s3')->setVisibility($file, 'public');
            //$fullURL = \Storage::disk('s3')->url($name); 
            $data[] = $path; 
        }
        $formFields['image_uploads']=json_encode($data);
        $formFields['category']=implode(", " ,$formFields['category']);

        Geocoder::setApiKey(config('geocoder.key'));
        Geocoder::setCountry(config('geocoder.country', 'US'));
        $resArr = Geocoder::getCoordinatesForAddress($formFields['street'].' '.$formFields['city']);

        $formFields['latitude'] = $resArr['lat'];
        $formFields['longitude'] = $resArr['lng'];

        // dd($formFields);
        $newRentable=Rentable::create($formFields);
        return redirect('/rentables/'.$newRentable->id)->with('message', 'Rental Created Successfully!');
    }

    public function show(Rentable $rentable){

        // option 1: when there are alot of items then we can be specific
            // $rentableQuery = DB::table('rentables');
            // $categories = explode(", ", $rentable->category); //there will always be atleast one category
            // $tags = explode(", ", $rentable->tags); //there will always be atleast one tag

            // $string = "Select * from rentables as r where r.id != " . $rentable->id . " AND " . "r.status NOT LIKE 'Rented'" . " AND ";
            // $string = $string . "( (";
            // foreach($categories as $category){
            //     $string = $string . "r.category LIKE '%" . $category . "%' OR ";
            // }
            // $string = substr($string, 0, -4);
            // $string = $string . ") OR (";
            // foreach($tags as $tag){
            //     $string = $string . "r.tags LIKE '%" . $tag . "%' OR ";
            // }
            // $string = substr($string, 0, -4);
            // $string = $string . ") ) limit 10";

            // $userQuery =DB::select($string);
            // $rentableQuery = Rentable::hydrate($userQuery);

        //option 2: when the data set size is relatively small, return random items from the database
                $rentableQuery = Rentable::inRandomOrder()
                            ->where('id', '!=', $rentable->id)
                            ->where( function ( $query )
                            {
                                $query->where( 'status', 'NOT LIKE', 'Rented' );
                            })->limit(10)->get();

        $userQuery = null;
        if(Auth::user()){
            $userQuery = DB::select(
                "
                SELECT users2.id, users2.first_name, users2.last_name, users2.avatar, users2.email, COUNT(case messages.is_read WHEN 0 then 1 else NULL end) as unread
                FROM users
                INNER JOIN messages on messages.to = users.id
                INNER JOIN users as users2 ON messages.from = users2.id
                WHERE messages.for_rentals = ". $rentable->id." and users2.id != ".auth()->id()."
                GROUP BY users2.id, users2.first_name, users2.last_name, users2.avatar, users2.email
                "
            );
        }

        return view('rentables.show',[
            // the current listings we are looking at
            'rentable' => $rentable,
            // list of relatd listings to be used in carousel
            'rentables' => $rentableQuery,
            // all users that have sent a message regarding current listing
            'allUsers' => $userQuery,
            //listing owner
            'rentableOwner' => User::find($rentable->user_id),
            // current users id
            'currentUser'=> Auth::guest() ? null : User::find(auth()->user()->id)
        ]);
    }

    public function destroy(Rentable $rentable){
        $this->removeFromRecommendations($rentable->id);
        if(is_array(json_decode($rentable->image_uploads))){
            foreach(json_decode($rentable->image_uploads) as $link){
               $this->removeImage($link);
            }
        }
        $rentable->delete();
        return redirect('/')->with('message', "Listing Deleted Successfully!");
    }

    public function removeFromRecommendations($id){
        $string = "Select * from watch_items as w where (w.type LIKE 'rentable') AND (w.matches_found LIKE '% " . $id .",%' OR w.matches_found LIKE '% " . $id ."%' )";
        $results = DB::select($string);

        foreach($results as $result){
            $matchedItems = explode(", ", $result->matches_found);
            if (($key = array_search($id, $matchedItems)) !== false) {
                unset($matchedItems[$key]);
            }
            DB::table('watch_items')->where('id', $result->id)->update(['matches_found' => implode(", ", $matchedItems)]);
        }
    }

    public function removeImage($filLink)
    {  
        if(\Storage::disk('s3')->exists($filLink)) {
            \Storage::disk('s3')->delete($filLink);
        }
    }

    public function updateStatus(Request $request, Rentable $rentable){
        // dd($request->all());
        if($rentable->user_id != auth()->id()){
            abort('404', 'Unauthorized Access');
            return redirect('/')->with('message', 'Please only edit listings you own');
        }
        $data = Rentable::find($rentable->id);
        $data->status = $request->status;
        $data->save();
        return back()->with('message', "Rentable Item Updated Successfully");
    }

    public function edit(Rentable $rentable){
        if($rentable->user_id != auth()->id()){
            abort('404', 'Unauthorized Access');
            return redirect('/')->with('message', 'Please only edit listings you own');
        }
        return view('rentables.edit', ['rentable' =>$rentable]);
    }

    public function update(Request $request, Rentable $rentable){
        // dd($request->all());
        if($rentable->user_id != auth()->id()){
            abort('404', 'Unauthorized Access');
            return redirect('/')->with('message', 'Please only edit listings you own');
        }
        $formFields = $request->validate([
            'user_id'=>'required',
            'rental_title'=>'required',
            'rental_duration' => 'required',
            'rental_charging'=>'required',
            'negotiable'=> 'required',
            'condition'=>'required',
            'category'=>'required',
            'tags'=>'required',
            'description'=>'required',
            'street'=>'required',
            'city'=>'required',
            'state'=>'required',
            'country'=>'required',
            'postcode'=>'required',
            // 'latitude' => 'required_without:street',
            // 'longitude' =>'required_without:street',
            'apartment_floor'=>'nullable'
        ]);

        $formFields['user_id']=auth()->id();
        
        if($request->file('image_uploads') != null){
            foreach ($request->file('image_uploads') as $file) {
                $path = $file->store('rentables','s3');
                \Storage::disk('s3')->setVisibility($file, 'public');
                //$fullURL = \Storage::disk('s3')->url($name); 
                $data[] = $path; 
            }
            $formFields['image_uploads']=json_encode($data);
        }
        
        $formFields['category']=implode(", " ,$formFields['category']);
        // dd($rentable);
        $rentable->update($formFields);
        return redirect('/rentables/'.$rentable->id)->with('message', 'Listing Updated Successfully!');
    }

    public static function getRentableById($rentable){
        // dd("test");
        return Rentable::find($rentable);
    }

    public static function updateViewCount($rentable) {
        $data = Rentable::find($rentable->id);
        $data->view_count = $rentable->view_count + 1;
        $data->save();
    }
}
