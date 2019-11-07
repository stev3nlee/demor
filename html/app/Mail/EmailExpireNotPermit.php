<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailExpireNotPermit extends Mailable implements ShouldQueue
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
      "title"=>"YOUR TIME IS EXPIRED"
      ,"image"=>url('assets/images/icons/email-contact.png')
      ,"data"=>$this->data
    );
    return $this->view('email/ordernotpermitexpire')->subject("Demor Boutique : Your time is expired")->with("data",$data);
    }
}
