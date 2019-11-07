<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailRegister extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
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
        "title"=>"ACTIVATE YOUR ACCOUNT"
        ,"image"=>url('assets/images/icons/email-register.png')
        ,"body"=>"Thank you for registering an account at Demorboutique. To activate your account, please click the following button:"
    		,"action"=>url("register/activate/".$this->data->userid."/".$this->data->ischange)
    		,"actionText"=>"ACTIVATE MY ACCOUNT"
      );
      return $this->view('email/defaultemail')->subject("Demor Boutique : Email Verification")->with("data",$data);
    }
}
