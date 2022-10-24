<?php

namespace App\Mail;

use App\Models\Message;
use App\Models\User;
use App\Models\Listing;
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
    public $listingUnreadInfo;
    public $rentalUnreadInfo;
    public $subleaseUnreadInfo;

    public function __construct($listingInfo, $rentalInfo, $subleaseInfo)
    {
        $this->listingUnreadInfo = $listingInfo;
        $this->rentalUnreadInfo = $rentalInfo;
        $this->subleaseUnreadInfo = $subleaseInfo;

        foreach ($this->listingUnreadInfo as $listing){
            echo "Listing ID: " . $listing->listingID;
            echo "\n";
            echo "Listing Name: " . $listing->itemName;
            echo "\n";
            echo "Sender First Name: " . $listing->senderFirstName;
            echo "\n";
            echo "Sender Last Name: " . $listing->senderLastName;
            echo "\n";
            echo "Number of messages: " . $listing->numMessages;
            echo "\n";
        }

        foreach ($this->rentalUnreadInfo as $rental){
            echo "Rental ID: " . $rental->rentalID;
            echo "\n";
            echo "Rental Name: " . $rental->itemName;
            echo "\n";
            echo "Sender First Name: " . $rental->senderFirstName;
            echo "\n";
            echo "Sender Last Name: " . $rental->senderLastName;
            echo "\n";
            echo "Number of messages: " . $rental->numMessages;
            echo "\n";
        }

        foreach ($this->subleaseUnreadInfo as $sublease){
            echo "Sublease ID: " . $sublease->subleaseID;
            echo "\n";
            echo "Sublease Name: " . $sublease->itemName;
            echo "\n";
            echo "Sender First Name: " . $sublease->senderFirstName;
            echo "\n";
            echo "Sender Last Name: " . $sublease->senderLastName;
            echo "\n";
            echo "Number of messages: " . $sublease->numMessages;
            echo "\n";
        }
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
