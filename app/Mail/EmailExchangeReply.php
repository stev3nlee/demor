<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailExchangeReply extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
	protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	  ini_set('max_execution_time', 120);
      $data=array(
        "title"=>"Your message has been received"
        ,"image"=>url('assets/images/icons/email-contact.png')
        ,"reply"=>$this->data
      );
      return $this->view('email/adminexchangereply')->subject("Demor Boutique : Thank you for the request exchange with us")->with("data",$data);
    }
}
