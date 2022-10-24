<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Mail\MessageReminderMail;
use App\Models\Message;
use App\Models\User;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:SendEmailsDaily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email reminders to people with unread messages once a day';

    /**
     * Execute the console command.
     *
     * @return int
     */
    //this is what the command does when called (find #of messages people have unread)
    public function handle()
    {
        $users = Message::join('users', 'messages.to','=','users.id')->select('users.id','users.email')->where('is_read','=','0')->distinct()->get();

        if ($users->count() > 0) {
            foreach ($users as $user) {
                \DB::statement("SET SQL_MODE=''");
                $unreadListings = Message::join('listings','messages.to','=','listings.user_id')
                ->join('users','users.id','=','messages.from')
                ->selectRaw('count(*) as numMessages, listings.id as listingID, listings.item_name as itemName, users.id as senderID, users.first_name as senderFirstName, users.last_name as senderLastName')
                ->where('is_read','=','0')->where('listings.user_id','=',$user->id)
                ->groupBy('messages.from','messages.to','listings.id','listings.user_id')
                ->orderBy('listings.id')->distinct()->get();

                $unreadRentals = Message::join('rentables','messages.to','=','rentables.user_id')
                ->join('users','users.id','=','messages.from')
                ->selectRaw('count(*) as numMessages, rentables.id as rentableID, rentables.rental_title as itemName, users.id as senderID, users.first_name as senderFirstName, users.last_name as senderLastName')
                ->where('is_read','=','0')->where('rentables.user_id','=',$user->id)->groupBy('messages.from','messages.to','rentables.id','rentables.user_id')
                ->orderBy('rentables.id')->distinct()->get();

                $unreadLease = Message::join('subleases','messages.to','=','subleases.user_id')
                ->join('users','users.id','=','messages.from')->selectRaw('count(*) as numMessages, subleases.id as subleaseID, subleases.sublease_title as itemName, users.id as senderID, users.first_name as senderFirstName, users.last_name as senderLastName')
                ->where('is_read','=','0')->where('subleases.user_id','=',$user->id)
                ->groupBy('messages.from','messages.to','subleases.id','subleases.user_id')
                ->orderBy('subleases.id')->distinct()->get();

                Mail::to($user->email)->send(new MessageReminderMail($unreadListings,$unreadRentals,$unreadLease));
                Message::where(['to' => $user->id])->update(['is_email' => 1]);
            }
        }
        return 0;
        //test
    }
}
