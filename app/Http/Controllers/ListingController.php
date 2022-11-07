<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use App\Models\Rentable;
use App\Models\Sublease;
use App\Models\YardSale;
use App\Libraries\HashMap;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\Geocoder\Facades\Geocoder;

class ListingController extends Controller
{

    // show a single listing
    public function show(Listing $listing)
    {
        // get the listings table
        // the listings array will hold listings that are similar to the current listing based on categories, if none then get 10 of the latest else add on to the existing and add remaining from the latest, so if there is 6 similar, then add 4 from latest that are unique

        // getting the related items for the bottom carousel

        // option 1: when there are alot of items then we can be specific
        // $listingQuery = DB::table('listings');
        // $categories = explode(", ", $listing->category); //there will always be atleast one category
        // $tags = explode(", ", $listing->tags); //there will always be atleast one tag

        // $string = "Select * from listings as l where l.id != " . $listing->id . " AND " . "l.status NOT LIKE 'SOLD'" . " AND ";
        // $string = $string . "( (";
        // foreach($categories as $category){
        //     $string = $string . "l.category LIKE '%" . $category . "%' OR ";
        // }
        // $string = substr($string, 0, -4);
        // $string = $string . ") OR (";
        // foreach($tags as $tag){
        //     $string = $string . "l.tags LIKE '%" . $tag . "%' OR ";
        // }
        // $string = substr($string, 0, -4);
        // $string = $string . ") ) limit 10";

        // $userQuery =DB::select($string);
        // $listingQuery = Listing::hydrate($userQuery);

        //option 2: when the data set size is relatively small, return random items from the database
        $listingQuery = Listing::inRandomOrder()
            ->where('id', '!=', $listing->id)
            ->where(function ($query) {
                $query->where('status', 'NOT LIKE', 'SOLD');
            })->limit(10)->get();



        header("Cache-Control: must-revalidate");
        return view('listings.show',[
            // the current listings we are looking at
            'listing' => $listing,
            // list of relatd listings to be used in carousel
            'listings' => $listingQuery,
            'listingOwner' => User::find($listing->user_id),
            // current users id
            'currentUser' => Auth::guest() ? null : User::find(auth()->user()->id),
            // all users that have sent a message regarding current listing
            'allUsers' => $userQuery,
        ]);
    }

    public function signup()
    {
        header("Cache-Control: must-revalidate");
        return view('user.loginSignup');
    }

    public function create()
    {
        header("Cache-Control: must-revalidate");
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'user_id'=>'required',
            'item_name'=>'required',
            'price'=>'required',
            'negotiable'=> 'required',
            'condition'=>'required',
            'category'=>'required',
            'tags'=>'required',
            'description'=>'required',
            'image_uploads'=>'required|max:5128',
            'street'=>'required',
            'city'=>'required',
            'state'=>'required',
            'country'=>'required',
            'postcode'=>'required',
            'latitude' => 'required_without:street',
            'longitude' =>'required_without:street',
            'apartment_floor'=>'nullable'
        ]);
        //  dd($formFields);
        $formFields['user_id'] = auth()->id();
        //since the images are required anyways, we know there will always be atleast one image
        //we have built in the check for size on the javascript side
        foreach ($request->file('image_uploads') as $file) {
            // if the size is smaller than 5mb then upload to aws s3 bucket
            if ($file->getSize() <= 5 * 1024 * 1024) {
                $path = $file->store('listings', 's3');
                \Storage::disk('s3')->setVisibility($file, 'public');
                //$fullURL = \Storage::disk('s3')->url($name); 
                $data[] = $path;
            }
        }

        $formFields['image_uploads'] = json_encode($data);
        $formFields['category'] = implode(", ", $formFields['category']);

        Geocoder::setApiKey(config('geocoder.key'));
        Geocoder::setCountry(config('geocoder.country', 'US'));
        $resArr = Geocoder::getCoordinatesForAddress($formFields['street'].' '.$formFields['city']);

        $formFields['latitude'] = $resArr['lat'];
        $formFields['longitude'] = $resArr['lng'];

        // dd($formFields);
        $newListing = Listing::create($formFields);
        return redirect('/listings/' . $newListing->id)->with('message', 'Listing Created Successfully!');
    }

    public function edit(Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            abort('404', 'Unauthorized Access');
            return redirect('/')->with('message', 'Please only edit listings you own');
        }
        // dd($listing);
        header("Cache-Control: must-revalidate");
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            abort('404', 'Unauthorized Access');
            return redirect('/')->with('message', 'Please only edit listings you own');
        }
        $formFields = $request->validate([
            'user_id' => 'required',
            'item_name' => 'required',
            'price' => 'required',
            'negotiable' => 'required',
            'condition' => 'required',
            'category' => 'required',
            'tags' => 'required',
            'description' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'postcode' => 'required',
            // 'latitude' => 'required_without:street',
            // 'longitude' =>'required_without:street',
            'apartment_floor' => 'nullable'
        ]);

        $formFields['user_id'] = auth()->id();
        if ($request->file('image_uploads') != null) {
            foreach ($request->file('image_uploads') as $file) {
                // if the size is smaller than 5mb then upload to aws s3 bucket
                if ($file->getSize() <= 5 * 1024 * 1024) {
                    $path = $file->store('listings', 's3');
                    \Storage::disk('s3')->setVisibility($file, 'public');
                    //$fullURL = \Storage::disk('s3')->url($name); 
                    $data[] = $path;
                }
            }

            $formFields['image_uploads'] = json_encode($data);
        }
        $formFields['category'] = implode(", ", $formFields['category']);
        // dd($formFields);

        $listing->update($formFields);

        $client = new \GuzzleHttp\Client();
        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('geocoder.key'));
        $geocoder->setCountry(config('geocoder.country', 'US'));
        $resArr = $geocoder->getCoordinatesForAddress($newListing->street.' '.$newListing->city);

        $newListing->latitude = $resArr['lat'];
        $newListing->longitude = $resArr['lng']; 

        return redirect('/listings/'.$listing->id)->with('message', 'Listing Updated Successfully!');
    }

    public function destroy(Listing $listing)
    {
        $this->removeFromRecommendations($listing->id);
        if (is_array(json_decode($listing->image_uploads))) {
            foreach (json_decode($listing->image_uploads) as $link) {
                $this->removeImage($link);
            }
        }
        $listing->delete();
        return redirect('/')->with('message', "Listing Deleted Successfully!");
    }

    public function removeFromRecommendations($id)
    {
        $string = "Select * from watch_items as w where (w.type LIKE 'listing') AND (w.matches_found LIKE '% " . $id . ",%' OR w.matches_found LIKE '% " . $id . "%' )";
        $results = DB::select($string);
        // dd($id ,"   " ,$string, $results);

        foreach ($results as $result) {
            $matchedItems = explode(", ", $result->matches_found);
            if (($key = array_search($id, $matchedItems)) !== false) {
                unset($matchedItems[$key]);
            }
            DB::table('watch_items')->where('id', $result->id)->update(['matches_found' => implode(", ", $matchedItems)]);
        }
    }

    public function removeImage($filLink)
    {
        /*if(file_exists(public_path($filLink))){
            unlink(public_path($filLink));
        }else{
            dd('File not found');
        }*/
        if (\Storage::disk('s3')->exists($filLink)) {
            \Storage::disk('s3')->delete($filLink);
        }
    }

    public function updateStatus(Request $request, Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            abort('404', 'Unauthorized Access');
            return redirect('/')->with('message', 'Please only edit listings you own');
        }
        $data = Listing::find($listing->id);
        $data->status = $request->status;
        $data->save();
        return back()->with('message', "Listing Updated Successfully");
    }

    public static function getListingById($listing)
    {
        // dd("test");
        //if no listing is found - > meaning the listing must have been deleted then remove that recommendation from that watchlist
        return Listing::find($listing);
    }

    public static function updateViewCount($listing)
    {
        $data = Listing::find($listing->id);
        $data->view_count = $listing->view_count + 1;
        $data->save();
    }
}
