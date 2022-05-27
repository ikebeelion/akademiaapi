<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $subject, $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $password)
    {
        $this->subject = $subject;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_NOREPLY_ADDRESS'), env('APP_NAME'))
        ->markdown('email.sendpassword')
        ->subject($this->subject);
    }
}
