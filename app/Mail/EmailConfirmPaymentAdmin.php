<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailConfirmPaymentAdmin extends Mailable implements ShouldQueue
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
		$body = '<div style="padding: 0 50px; margin-bottom: 15px;">
					<div style="margin-bottom: 15px;">
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">FULL NAME</div>			
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">'. $this->data->orderheader[0]->membername .'</div>
					</div>
					<div style="margin-bottom: 15px;">
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ORDER NO.</div>			
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">'. $this->data->orderheader[0]->orderno .'</div>
					</div>
					<div style="margin-bottom: 15px;">
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ACCOUNT NO.</div>			
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">'. $this->data->orderheader[0]->accountno .'</div>
					</div>
					<div style="margin-bottom: 15px;">
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ACCOUNT NAME</div>			
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">'. $this->data->orderheader[0]->accountname .'</div>
					</div>
					<div style="margin-bottom: 15px;">
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PAYMENT TO</div>			
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">'. $this->data->paymentto[0]->bankname .' - '. $this->data->paymentto[0]->accountnumber.' - '.$this->data->paymentto[0]->bankaccountname .'</div>
					</div>
					<div style="margin-bottom: 15px;">
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">TOTAL AMOUNT</div>			
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">IDR '.str_replace(",",".",number_format($this->data->orderheader[0]->totalamount)).'</div>
					</div>
				</div>';
		
		$payment=array(
			"title"=>"Someone has confirmed the payment."
			,"image"=>url('assets/images/icons/email-contact.png')
			,"body"=>$body
			,"action"=>""
			,"actionText"=>""
		);
		return $this->view('email/defaultemail')->subject("Demor Boutique : Someone has confirmed payment")->with("data",$payment);
    }
}
