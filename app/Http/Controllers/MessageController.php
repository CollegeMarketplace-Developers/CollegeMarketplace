<?php

namespace App\Http\Controllers;

use Pusher\Pusher;
use App\Models\User;
use App\Models\Listing;
use App\Models\Message;
use App\Models\Rentable;
use App\Models\Sublease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //
    public function getMessages(Request $request)
    {
        // if the current listing is mine that i have clicked on
        //all messages will be from the other person(s) to me
        // return "from: ".$request->from . " " . " to: ". $request->to . " listing_id=" . $request->listing_id;

        $from = $request->from;
        $to = $request->to;
        $listing_id = $request->listing_id;
        $rental_id = $request->rental_id;

        // Make read all unread message
        Message::where(['from' => $from, 'to' => $to])->update(['is_read' => 1]);

        $messages = Message::where(
            function ($query) use ($from, $to, $listing_id) {
                $query->where('from', $from)->where('to', $to)->where('for_listing', $listing_id);
            }
        )->orWhere(function ($query) use ($from, $to, $listing_id) {
            $query->where('from', $to)->where('to', $from)->where('for_listing', $listing_id);
        })->get();

        // dd($messages);
        return $messages;
        // from Auth::id() to $user_id or $user_id to Auth::id();

        // for now, we want from $listing->user_id to reciever id, which will be passed in as $user_id
    }

    public function postMessage(Request $request)
    {
        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;
        $listing_id = $request->for_listing;
        $rental_id = $request->for_rentals;
        $sublease_id = $request->for_sublease;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->for_listing = $listing_id;
        $data->for_rentals = $rental_id;
        $data->for_sublease = $sublease_id;
        $data->message = $message;
        $data->is_read = 0; // message will be unread when sending message
        $data->save();


        // pusher
        $options = array(
            'cluster' => 'us2'
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to, 'for_listing' => $listing_id, 'for_rentals' => $rental_id, 'for_sublease' => $sublease_id]; // sending from and to user id when pressed enter

        $pusher->trigger('my-channel', 'my-event', $data);

        $response = array(
            'status' => 'success',
            'reciever_id' => $request->receiver_id,
            'for_listing' => $request->for_listing,
            // 'message' => $request -> message
            'for_rentals' => $request->for_rentals,
            'for_sublease' => $request->for_sublease,
            "message" => $data
        );
        return response()->json($response);
    }

    public function goToMessagePage(Request $request){
        // dd( $request->type, $request->itemID, $request->ownerID, $request->from);
        if($request->type=='listing'){
            $listing = Listing::find($request->itemID);
            $userQuery = null;
            if(Auth::user()){
                $userQuery = DB::select(
                    "
                    SELECT users2.id, users2.first_name, users2.last_name, users2.avatar, users2.email, COUNT(case messages.is_read WHEN 0 then 1 else NULL end) as unread
                    FROM users
                    INNER JOIN messages on messages.to = users.id
                    INNER JOIN users as users2 ON messages.from = users2.id
                    WHERE messages.for_listing = ". $listing->id." and users2.id != ".auth()->id()."
                    GROUP BY users2.id, users2.first_name, users2.last_name, users2.avatar, users2.email
                    "
                );
            }
            
            // dd($userQuery);
            // dd(Auth::guest());

            // dd($request->type, $listing, User::find($listing->user_id),$request->from, $userQuery );
            return view('users.message-page', [
                // type of object 
                'type'=>$request->type,
                // the item itself
                'listing' => $listing,
                //owner of the item
                'listingOwner' => User::find($listing->user_id),
                // currentUser is the one from
                'currentUser' => $request->from,
                // all users that have sent a message regarding current listing
                'allUsers' => $userQuery,
            ]);
        }

        // add two more else ifs for rentables and lease items
        dd('didnt work | check message controller | goToMessagePage');
    }
}
