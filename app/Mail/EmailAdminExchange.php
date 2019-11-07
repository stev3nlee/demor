<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailAdminExchange extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $name;
    private $orderId;
    private $productName;
    private $productDetail;
    private $reason;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->name = $data->fullName;
        $this->orderId = $data->invoiceNumber;
        $this->productName = $data->productName;
        $this->productDetail = $data->detailProduct;
        $this->reason = $data->reason;
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
        "title"=>"Someone has left you a message"
        ,"image"=>url('assets/images/icons/email-contact.png')
        ,"name"=>$this->name
        ,"orderId"=>$this->orderId
        ,"productName"=>$this->productName
        ,"productDetail"=>$this->productDetail
        ,"reason"=>$this->reason
      );
      return $this->view('email/adminexchangemail')->subject("Demor Boutique : Someone has sent you an exchange form")->with("data",$data);
    }
}
