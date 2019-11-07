<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailForgotPassword extends Mailable implements ShouldQueue
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
        "title"=>"Your message has been received"
        ,"image"=>url('assets/images/icons/email-forgot.png')
        ,"body"=>"Dear Customer, <br>On ".date("d M Y H:i")." you have requested a password reset. To reset your password, please click the following button:"
    		,"action"=>url("forgot/new/".$this->data->userid."/".$this->data->ischange)
    		,"actionText"=>"RESET MY PASSWORD"
      );
      return $this->view('email/defaultemail')->subject("Demor Boutique : Reset Password")->with("data",$data);
    }
}
