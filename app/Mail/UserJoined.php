<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserJoined extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_user)
    {
        $this->user=$_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $contact=getSetting('contact');
        // dd($contact);
        return $this->view('email.userJoined',['user'=>$this->user,'contact'=>$contact]);
    }
}
