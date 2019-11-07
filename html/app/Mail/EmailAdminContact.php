<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailAdminContact extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $name;
    private $email;
    private $content_subject;
    private $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
      $this->name   = $data->name;
      $this->email  = $data->email;
      $this->content_subject = $data->subject;
      $this->message = $data->messages;
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
        "title"=>"Someone send you a message"
        ,"image"=>url('assets/images/icons/email-contact.png')
        ,"name"=>$this->name
        ,"email"=>$this->email
        ,"content_subject"=>$this->content_subject
        ,"message"=>$this->message
      );
      return $this->view('email/admincontactmail')->subject("Demor Boutique : Someone has sent you a message")->with("data",$data);
    }
}
