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
    protected $signature = 'auto:SendMail';

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
        //$users = Message::join('users', 'messages.to','=','users.id')->select('users.email','is_email')->distinct()->where('is_read','=','0')->where('is_email','=','0')->get();
        $users = Message::join('users', 'messages.to','=','users.id')->selectRaw('count(*) as numMessages, users.email,messages.to')->groupBy('messages.to','users.email')->where('is_read','=','0')->where('is_email','=','0')->get();
        //$userAndCount = Message::selectRaw('count(*) as numMessages, to')->where('is_read','=','0')->where('is_email','=','0')->groupBy('to');
        //echo $userAndCount->count();
        if ($users->count() > 0) {
            foreach ($users as $user) {
                //$userEmail = User::select('users.email')->where('id','=',$user->to);
                Mail::to($user->email)->send(new MessageReminderMail($user->numMessages));
                Message::where(['to' => $user->to])->update(['is_email' => 1]);
                //$user->is_email=1;
            }
        }
        return 0;
        //test
    }
}
