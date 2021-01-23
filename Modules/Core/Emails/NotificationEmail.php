<?php

namespace Modules\Core\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $message1;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message1,$link)
    {   
        $this->message1 = $message1;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->subject('Important Excel Notification')->view('core::notificationemail');;
    }
}
