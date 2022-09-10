<?php

namespace App\Mail;

use App\Models\Message;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    //this will be accessable in the view (anything publicly declared here is accessible in the view)
    //can add more stuff if want to display other things in the email
    public $numUnreadMessages;


    public function __construct($numMess)
    {
        //echo $numMess;
        $this->numUnreadMessages = $numMess;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('You have unread messages!')->view('MailTemplates.reminderemail');
    }
}
