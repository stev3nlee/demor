<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailContact extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        ,"body"=>"Dear Customer
			<br>Thank you for contacting us. Please wait up to 1 x 24 hours to receive a reply.
			<br>To make sure our reply doesn't get into your spam box, please add cs@demorboutique.com to your spam filter."
		,"action"=>""
		,"actionText"=>""
      );
      return $this->view('email/defaultemail')->subject("Demor Boutique : Thank you for contacting us")->with("data",$data);
    }
}
