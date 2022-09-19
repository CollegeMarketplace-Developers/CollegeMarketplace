<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use App\Models\Rentable;
use App\Models\Sublease;
use App\Models\Message;
use App\Libraries\HashMap;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function features()
    {
        header("Cache-Control: must-revalidate");
        return view('main.features');
    }

    public function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {
        $earth_radius = 3959;
    
        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);
    
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;
    
        return $d;
    }
    
    //MashAllah!
     //show the index page
    public function index(){
        //Option 1: return results that were added in the last 24 hours for only sale items
        // $latest = Listing::latest()->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->simplePaginate(16);
        // if(count($latest) == 0){
        //     $latest = Listing::latest()->take(16)->get();
        // }
        /*$user = User::find(auth()->user());
        if($user != null) {
            \DB::statement("SET SQL_MODE=''");
            dd(Message::latest()->where('to','=',$user->first()->id)->where('is_read','=','0')->groupBy('from')->get());
        }*/
        
        //dd($users = Message::join('users', 'messages.to','=','users.id')->selectRaw('count(*) as numMessages, users.email,messages.to')->groupBy('messages.to','users.email')->where('is_read','=','0')->where('is_email','=','0')->get());
        //dd(Message::selectRaw('count(*) as numMessages,to')->where('is_read','=','0')->where('is_email','=','0')->groupBy('to'));
        //dd(Message::where('is_read','=','0')->where('is_email','=','0')->groupBy('to')->count());
        //dd(Message::join('users', 'messages.to','=','users.id')->select('messages.message','messages.created_at','users.email')->where('is_read','=','0')->where('is_email','=','0')->get());
        

        //Option 2: retun results from all three types that are the latest
        $listingResults = Listing::latest()->where('status', '!=', 'Sold')->limit(40)->get();
        $rentableResults = Rentable::latest()->where('status', 'like', 'Available')->limit(40)->get();
        $subleaseResults = Sublease::latest()->where('status', 'like', 'Available')->limit(40)->get();
        $totalResults = collect($listingResults)->merge($rentableResults)->merge($subleaseResults)->sortByDesc('created_at')->slice(0, 40);
        // dd($totalResults);

        $furnitureItems = Listing::latest()->where('status', '!=', 'Sold')->Where('category', 'LIKE', '%furniture%')->limit(10)->get();
        $clothesItems = Listing::latest()->where('status', '!=', 'Sold')->where('category', 'LIKE', '%clothes%')->limit(10)->get();
        $electronicsItems = Listing::latest()->where('status', '!=', 'Sold')->where('category', 'LIKE', '%electronics%')->limit(10)->get();
        $kitchenItems = Listing::latest()->where('status', '!=', 'Sold')->where('category', 'LIKE', '%kitchen%')->limit(10)->get();
        $schoolItems = Listing::latest()->where('status', '!=', 'Sold')->where('category', 'LIKE', '%school accessories%')->limit(10)->get();
        $bookItems = Listing::latest()->where('status', '!=', 'Sold')->where('category', 'LIKE', '%books%')->limit(10)->get();


        $furnitureRent = Rentable::latest()->where('status', '!=', 'Rented')->where('category', 'LIKE', '%furniture%')->limit(10)->get();
        $clothesRent = Rentable::latest()->where('status', '!=', 'Rented')->where('category', 'LIKE', '%clothes%')->limit(10)->get();
        $electronicsRent = Rentable::latest()->where('status', '!=', 'Rented')->where('category', 'LIKE', '%electronics%')->limit(10)->get();
        $kitchenRent = Rentable::latest()->where('status', '!=', 'Rented')->where('category', 'LIKE', '%kitchen%')->limit(10)->get();
        $schoolRent = Rentable::latest()->where('status', '!=', 'Rented')->where('category', 'LIKE', '%school accessories%')->limit(10)->get();
        $bookRent = Rentable::latest()->where('status', '!=', 'Rented')->where('category', 'LIKE', '%books%')->limit(10)->get();

        //     dd(collect($furnitureItems)->merge($furnitureRent)->sortByDesc('created_at')->slice(0,16),
        // collect($clothesItems)->merge($clothesRent)->sortByDesc('created_at')->slice(0,16)
        //     );
        // dd($furnitureItems);

        header("Cache-Control: must-revalidate");
    //     dd(collect($furnitureItems)->merge($furnitureRent)->sortByDesc('created_at')->slice(0,16),
    // collect($clothesItems)->merge($clothesRent)->sortByDesc('created_at')->slice(0,16)
    //     );

        $listingResultsFull = Listing::latest()->where('status', '!=', 'Sold' )->limit(50)->get();
        $retnablesResultsFull = Rentable::latest()->where('status', '!=', 'Rented' )->limit(50)->get();
        $subleaseResultsFull = Sublease::latest()->where('status', 'like', 'Available' )->limit(50)->get();
        $allFull = collect($listingResultsFull)->merge($retnablesResultsFull)->merge($subleaseResultsFull)->sortByDesc('created_at');

        $stack = array();
        $user = User::find(auth()->user());
        
        if($user != null) {
            $currentUser = $user->first();
            
            //if the user has an address saved (if the user has an address saved they will always have latitude and longitude bec of the way its implemented)
            if($currentUser->latitude != NULL && $currentUser->longitude != NULL) {
                //$listingResultsFull = Listing::latest()->where('status', '!=', 'Sold' )->get();
                $counter = 0;
                foreach ($allFull as $res) {
                    //make sure the listing by the owner wont show up in the carousel
                    if($res->user_id != $currentUser->id) {
                        if($this->getDistance($currentUser->latitude,$currentUser->longitude,$res->latitude,$res->longitude) <= 1) {
                            array_push($stack,$res);
                            $counter+=1;
                        }
                    }
                    if($counter == 10){
                        break;
                    }
                }
            }
        }
        
        return view('main.index', [
            'listings'=> $totalResults,
            'furnitureItems' => collect($furnitureItems)->merge($furnitureRent)->sortByDesc('created_at')->slice(0,16),
            'clothesItems' => collect($clothesItems)->merge($clothesRent)->sortByDesc('created_at')->slice(0,16),
            'electronicsItems' => collect($electronicsItems)->merge($electronicsRent)->sortByDesc('created_at')->slice(0,16),
            'kitchenItems' => collect($kitchenItems)->merge($kitchenRent)->sortByDesc('created_at')->slice(0,16),
            'schoolItems' => collect($schoolItems)->merge($schoolRent)->sortByDesc('created_at')->slice(0,16),
            'bookItems' => collect($bookItems)->merge($bookRent)->sortByDesc('created_at')->slice(0,16),
            //'listingsNear' => Listing::latest()->where('status', '!=', 'Sold' )->take(10)->get(),
            'listingsNear' => $stack,
            'rentables' => Rentable::latest()->where('status', 'like', 'Available' )->take(10)->get(),
            'subleases'=>Sublease::latest()->where('status', 'like', 'Available')->take(10)->get(),
            'user' => $user
        ]);
    }

    //method to be used in the ajax request
    public function getUnreadMessages(Request $request) {
        return $this->getUnrdMessages();
    }

    //helper method to get unread messages to display in notification tab (latest one from each user)
    public function getUnrdMessages() {
        $resultArr = array();

        $user = User::find(auth()->user());
        \DB::statement("SET SQL_MODE=''");
        $messages = Message::join('users','messages.from','=','users.id')->orderBy('messages.created_at','desc')->where('to','=',$user->first()->id)->where('is_read','=','0')->groupBy('from')->limit(10)->get();

        /*foreach($messages as $mess) {
            $resultArr[User::select('*')->where('id','=',$mess->from)] = $mess;
        }*/
        return $messages;
    }

    //get active posts
    public function getActivePosts(Request $request) {
        return $this->getAP();
    }

    public function getAP() {
        $user = User::find(auth()->user());

        $listingResultsFull = Listing::latest()->where('status', '!=', 'Sold' )->where('user_id','=',$user->first()->id)->limit(10)->get();
        $retnablesResultsFull = Rentable::latest()->where('status', '!=', 'Rented' )->where('user_id','=',$user->first()->id)->limit(10)->get();
        $subleaseResultsFull = Sublease::latest()->where('status', 'like', 'Available' )->where('user_id','=',$user->first()->id)->limit(10)->get();
        $allFull = collect($listingResultsFull)->merge($retnablesResultsFull)->merge($subleaseResultsFull)->sortByDesc('created_at');

        return $allFull;
    }

    public function getListingsFromLatLng(Request $request) {
        //error_log($request->longitude);
        return $this->getProximateListings($request->latitude,$request->longitude); 
        //return array('success'=>'it worked');
    }

    //helper method to get listings within a mile
    public function getProximateListings($latitude, $longitude) {
        //error_log($longitude);
        $stack = array();
        
        $listingResultsFull = Listing::latest()->where('status', '!=', 'Sold' )->limit(50)->get();
        $retnablesResultsFull = Rentable::latest()->where('status', '!=', 'Rented' )->limit(50)->get();
        $subleaseResultsFull = Sublease::latest()->where('status', 'like', 'Available' )->limit(50)->get();
        $allFull = collect($listingResultsFull)->merge($retnablesResultsFull)->merge($subleaseResultsFull)->sortByDesc('created_at');

        $counter = 0;
    
        //error_log((float) $latitude.' '.(float)$longitude);

        foreach ($allFull as $res) {
            //make sure the listing by the owner wont show up in the carousel
            if($this->getDistance(floatval($latitude),floatval($longitude),$res->latitude,$res->longitude) <= 1) {
                array_push($stack,$res);
                $counter+=1;
            }
            if($counter == 10){
                break;
            }
        }
        return $stack;
    }

    public function search(Request $request){
        // dd(\Request::getRequestUri());
        $map = new HashMap("String", "Array");
        $input = $request->except('_token');
        foreach ($input as $key => $value) {
            if ($key == "page") {
                continue;
            }
            $value = explode(",", $value);
            $map->put($key, $value);
        }
        // dd($request ->all());
        // dd("test");
        if (
            $request->fullUrl() != $request->url() &&
            ((request('distance') ?? false)
                || (request('negotiableFree') ?? false)
                || (request('search') ?? false)
                || (request('category') ?? false)
                || (request('tag') ?? false)
                || (request('condition') ?? false)
                || (request('type') ?? false))
        ) {
            if ((request('type') ?? false) && request('type') == 'listing') {
                // show results from rentables table with filters applied
                $totalResults = null;
                if (!empty($request->except('_token', 'type', 'page'))) {
                    $listingResults = $this->getListingsQuery($request);
                    $totalResults = collect($listingResults)->sortByDesc('id')->paginate(50);
                } else {
                    $totalResults = collect(Listing::latest()->get())->sortByDesc('id')->paginate(50);
                }

                header("Cache-Control: must-revalidate");
                return view('main.search', [
                    'listings' => $totalResults
                ]);
            } elseif ((request('type') ?? false) && request('type') == 'rentable') {
                // show results from rentables table with filters applied
                $totalResults = null;
                if (!empty($request->except('_token', 'type', 'page'))) {
                    $rentableResults = $this->getRentableQuery($request);
                    $totalResults = collect($rentableResults)->sortByDesc('id')->paginate(50);
                } else {
                    $totalResults = Rentable::latest()->paginate(50);
                }

                header("Cache-Control: must-revalidate");
                return view('main.search', [
                    'listings' => $totalResults
                ]);
            } elseif ((request('type') ?? false) && request('type') == 'lease') {
                $totalResults = null;
                if (!empty($request->except('_token', 'type', 'page', 'category'))) {
                    $subleaseResults = $this->getSubleaseQuery($request);
                    $totalResults = collect($subleaseResults)->sortByDesc('id')->paginate(50);
                } else {
                    $totalResults = Sublease::latest()->paginate(50);
                }

                header("Cache-Control: must-revalidate");
                return view('main.search', [
                    'listings' => $totalResults
                ]);
            } elseif ((request('type') ?? false) && request('type') == 'all') {
                $totalResults = null;
                if (!empty($request->except('_token', 'type', 'page'))) {
                    $listingResults = $this->getListingsQuery($request);
                    $rentableResults = $this->getRentableQuery($request);
                    $subleaseResults = $this->getSubleaseQuery($request);
                    $totalResults = collect($listingResults)->merge($rentableResults)->merge($subleaseResults)->sortByDesc('id')->paginate(50);
                } else {
                    $totalResults = collect(Listing::latest()->get())->merge(Rentable::latest()->get())->merge(Sublease::latest()->get())->sortByDesc('id')->paginate(50);
                }

                header("Cache-Control: must-revalidate");
                return view('main.search', [
                    'listings' => $totalResults
                ]);
            }
        }
    }

    public function getListingsQuery(Request $map)
    {
        $map = $map->except('_token', 'type', 'page', 'utilities');
        // dd($map);
        if (!empty($map)) {
            $string = "Select * from listings as l where ";
            foreach ($map as $key => $values) {
                // dd($key);
                // dd($values);
                if ($key == "search") {
                    $arrayValues = explode(" ", $values);
                    $string = $string . "(";
                    foreach ($arrayValues as $value) {
                        $string = $string . " (";
                        $string = $string . "l.item_name LIKE '%" . $value . "%' OR ";
                        $string = $string . "l.tags LIKE '%" . $value . "%' OR ";
                        $string = $string . "l.description LIKE '%" . $value . "%' OR ";
                        $string = substr($string, 0, -4);
                        $string = $string . ")";
                        $string = $string . " AND ";
                    }
                    $string = substr($string, 0, -4);
                    $string = $string . ")";
                    // dd('top branch');
                } elseif ($key == 'tags') {
                    $string = $string . " (";
                    $string = $string . "l.tags LIKE '%" . $values . "%'";
                    $string = $string . ")";
                } elseif ($key == 'category') {
                    //can have multiple categories selected
                    $categories = explode(",", $values);
                    $string = $string . "(";
                    foreach ($categories as $category) {
                        $string = $string . "l.category LIKE '%" . $category . "%' OR ";
                    }
                    $string = substr($string, 0, -4);
                    $string = $string . ")";
                } elseif ($key == 'minprice') {
                    $string = $string . "(";
                    $string = $string . "l.price >= " . $values;
                    $string = $string . ")";
                } elseif ($key == "maxprice") {
                    $string = $string . "(";
                    $string = $string . "l.price <= " . $values;
                    $string = $string . ")";
                } else { //else bit takes care of condition & price
                    $arrayValues = explode(",", $values);
                    // dd($arrayValues);
                    $string = $string . "(";
                    foreach ($arrayValues as $value) {
                        $string = $string . "l." . $key . " = '" . $value . "' OR ";
                    }
                    $string = substr($string, 0, -4);
                    $string = $string . ")";
                }
                $string = $string . " AND ";
            }
            $string = substr($string, 0, -5);

            $userQuery = DB::select($string);
            return Listing::hydrate($userQuery);
        }
    }

    public function getRentableQuery(Request $map)
    {
        $map = $map->except('_token', 'type', 'page', 'utilities');
        if (!empty($map)) {
            $string = "Select * from rentables as r where ";
            foreach ($map as $key => $values) {
                if ($key == "search") {
                    $arrayValues = explode(" ", $values);
                    $string = $string . "(";
                    foreach ($arrayValues as $value) {
                        $string = $string . " (";
                        $string = $string . "r.rental_title LIKE '%" . $value . "%' OR ";
                        $string = $string . "r.tags LIKE '%" . $value . "%' OR ";
                        $string = $string . "r.description LIKE '%" . $value . "%' OR ";
                        $string = substr($string, 0, -4);
                        $string = $string . ")";
                        $string = $string . " AND ";
                    }
                    $string = substr($string, 0, -4);
                    $string = $string . ")";
                } elseif ($key == 'tags') {
                    $string = $string . " (";
                    $string = $string . "r.tags LIKE '%" . $values . "%'";
                    $string = $string . ")";
                } elseif ($key == 'category') {
                    $categories = explode(",", $values);
                    $string = $string . "(";
                    foreach ($categories as $category) {
                        $string = $string . "r.category LIKE '%" . $category . "%' OR ";
                    }
                    $string = substr($string, 0, -4);
                    $string = $string . ")";
                } elseif ($key == 'minprice') {
                    $string = $string . "(";
                    $string = $string . "r.rental_charging >= " . $values;
                    $string = $string . ")";
                } elseif ($key == "maxprice") {
                    $string = $string . "(";
                    $string = $string . "r.rental_charging <= " . $values;
                    $string = $string . ")";
                } else { //else bit takes care of condition & price
                    $arrayValues = explode(",", $values);
                    $string = $string . "(";
                    foreach ($arrayValues as $value) {
                        $string = $string . "r." . $key . " = '" . $value . "' OR ";
                    }
                    $string = substr($string, 0, -4);
                    $string = $string . ")";
                }
                $string = $string . " AND ";
            }
            $string = substr($string, 0, -5);
            // dd($string);
            $userQuery = DB::select($string);
            return Rentable::hydrate($userQuery);
        }
    }

    public function getSubleaseQuery(Request $map)
    {
        $map = $map->except('_token', 'type', 'page', 'category', 'tags');
        //done search, condition, price, utilities
        if (!empty($map)) {
            $string = "Select * from subleases as s where ";
            foreach ($map as $key => $values) {
                if ($key == "search") {
                    $arrayValues = explode(" ", $values);
                    $string = $string . "(";
                    foreach ($arrayValues as $value) {
                        $string = $string . " (";
                        $string = $string . "s.sublease_title LIKE '%" . $value . "%' OR ";
                        $string = $string . "s.location LIKE '%" . $value . "%' OR ";
                        $string = $string . "s.description LIKE '%" . $value . "%' OR ";
                        $string = substr($string, 0, -4);
                        $string = $string . ")";
                        $string = $string . " AND ";
                    }
                    $string = substr($string, 0, -4);
                    $string = $string . ")";
                } elseif ($key == 'minprice') {
                    $string = $string . "(";
                    $string = $string . "s.rent >= " . $values;
                    $string = $string . ")";
                } elseif ($key == "maxprice") {
                    $string = $string . "(";
                    $string = $string . "s.rent <= " . $values;
                    $string = $string . ")";
                } else { //else bit takes care of condition & price & utilities
                    $arrayValues = explode(",", $values);
                    // dd($arrayValues);
                    $string = $string . "(";
                    foreach ($arrayValues as $value) {
                        $string = $string . "s." . $key . " = '" . $value . "' OR ";
                    }
                    $string = substr($string, 0, -4);
                    $string = $string . ")";
                }
                $string = $string . " AND ";
            }
            $string = substr($string, 0, -5);
            // dd($string);
            $userQuery = DB::select($string);
            return Sublease::hydrate($userQuery);
        }
    }

    public function enrollEmail(Request $request)
    {
        // dd($request->all());
        $formfields = [
            'email' => $request->email
        ];

        $existing = NewsLetter::where('email', 'like', $request->email)->get();
        if (count($existing) > 0) {
            return back()->with('message', 'Email Already Enrolled in News Letter');
        }

        $checkUser = User::where('email', 'like', $request->email)->get()->first();
        if ($checkUser != null) {
            $formfields['user_id'] = $checkUser->id;
        }
        $enrollEmail = NewsLetter::create($formfields);
        return back()->with('message', 'Successfully Enrolled in News Letter');
    }

    public static function getRandomItem()
    {
        // $model1s = Listing::inRandomOrder()->take(1)->get();
        // $model2s = Rentable::inRandomOrder()->take(1)->get();
        // $model3s = Sublease::inRandomOrder()->take(1)->get();
        // $result =  $model1s->concat($model2s)->concat($model3s)->shuffle()->random();

        $array = array();
        $listing = Listing::inRandomOrder()->where('status', '!=', 'Sold')->first();
        $rental = Rentable::inRandomOrder()->where('status', 'like', 'Available')->first();
        $lease = Sublease::inRandomOrder()->where('status', 'like', 'Available')->first();
        array_push($array, $listing);
        array_push($array, $rental);
        array_push($array, $lease);
        $get = $array[random_int(0, count($array) - 1)];
        while (count($array) > 0) {
            if ($get == null) {
                if (($key = array_search($get, $array)) !== false) {
                    unset($array[$key]);
                }
            } else {
                return $get;
            }
        }
        return null;
    }
}
