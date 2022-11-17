<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
    public static function setCookie(Listing $listing){
        $name = 'recentlyViewed';
        $time = 2628000; //this is 5 years
        $recentlyViewed = Cookie::has('recentlyViewed') ? explode(", ", Cookie::get('recentlyViewed')) : null;

        if($recentlyViewed == null){
            $recentlyViewed = Cookie::forever($name, implode(", ", array($listing)), $time);
        }else{
            Cookie::queue(Cookie::forget($name));
            if(count($recentlyViewed) >= 10){
                array_shift($recentlyViewed);
            }
            array_push($recentlyViewed, $listing);
            $recentlyViewed = Cookie::forever($name, implode(", ", $recentlyViewed), $time);
        }
        
        $response = new Response("Set Cookie Data");
        $response->withCookie($recentlyViewed);
        // cookie()->forever('recentlyViewed', implode(" ", $recentlyViewed))
        return $response;
        // dd($response);
        // dd($request);
    }

    public function getCookie(Request $request){

    }
}
