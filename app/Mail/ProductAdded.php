<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductAdded extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $bill;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_user,$_bill)
    {
        $this->user=$_user;
        $this->bill=$_bill;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject="Invoice for ".$this->bill->particular;
        return $this->view('email.bill',['user'=>$this->user,'bill'=>$this->bill]);
    }
}
