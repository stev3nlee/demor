<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailOrderReminder extends Mailable implements ShouldQueue
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
		$body = "";
		$action = '<div style="border-top: 1px solid #b69bbc; padding-top: 30px; margin: 30px 0;">
					<div style="margin-bottom: 15px;">
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ORDER NO.</div>
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">'.$this->data->orderheader[0]->orderno.'</div>
					</div
					<div style="margin-bottom: 15px;">
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PAYMENT STATUS</div>
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #d98500; line-height: 25px; font-weight: bold;">PENDING</div>
					</div>
					<div>
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">SHIPPING STATUS</div>
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #d98500; line-height: 25px; font-weight: bold;">PENDING</div>
					</div>	';
		$action1 = ''; $action2 = ''; $action3 = ''; $action4 = '';

		$body = '<div style="margin-bottom:15px;">Dear Customer, <br>Please make your payment via bank transfer in the next 1-hour, otherwise your order will be automatically cancelled. If your order has been cancelled, please place a new order through our website. <br> The following is a detailed information for your order:</div>';


		$action1 .= '</div>
					<div style="border-top: 1px solid #b69bbc; padding-top: 30px; margin: 30px 0;">
						<div style="margin-bottom: 20px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ORDER DETAILS</div>
						<div style="margin-bottom: 15px;">
							<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">FULL NAME</div>
							<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">'.$this->data->orderheader[0]->membername.'</div>
						</div>
						<div style="margin-bottom: 15px;">
							<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ORDER TOTAL</div>
							<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">IDR '.str_replace(",",".",number_format($this->data->orderheader[0]->subtotal - $this->data->orderheader[0]->vouchernominal + $this->data->orderheader[0]->conveniencefee + $this->data->orderheader[0]->shippingfee + $this->data->orderheader[0]->tax)).'</div>
						</div>
						<div style="margin-bottom: 15px;">
							<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PAYMENT METHOD</div>
		          <div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">Bank Transfer</div>';

		$action1 .=	 '</div>
						<div style="margin-bottom: 15px;">
							<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold; vertical-align: top;">BILLING ADDRESS</div>
							<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">
								<div>'.$this->data->orderinfo[1]->address.'</div>
								<div>'.$this->data->orderinfo[1]->city.', '.$this->data->orderinfo[1]->zipcode.'</div>
								<div>'.$this->data->orderinfo[1]->state.', '.$this->data->orderinfo[1]->country.'</div>
							</div>
						</div>
						<div>
							<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold; vertical-align: top;">SHIPPING ADDRESS</div>
							<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">
								<div>'.$this->data->orderinfo[0]->address.'</div>
								<div>'.$this->data->orderinfo[0]->city.', '.$this->data->orderinfo[0]->zipcode.'</div>
								<div>'.$this->data->orderinfo[0]->state.', '.$this->data->orderinfo[0]->country.'</div>
							</div>
						</div>
					</div>
					<div style="border-top: 1px solid #b69bbc; padding-top: 30px; margin: 30px 0;">
						<div style="margin-bottom: 20px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">YOUR SHOPPING BAG</div>';


		$action3 .= '<div style="margin-bottom: 30px;">
						<div style="margin-bottom: 5px; padding: 0 20px;">
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px;">SUBTOTAL</div>
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; text-align: right;">IDR '.str_replace(",",".",number_format($this->data->orderheader[0]->subtotal)).'</div>
						</div>';
		if($this->data->orderheader[0]->voucherid != 0){
			$action3 .= '<div style="margin-bottom: 5px; padding: 0 20px;">
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #ff4646; line-height: 25px;">VOUCHER ('.$this->data->orderheader[0]->voucher.')</div>
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #ff4646; line-height: 25px; text-align: right;">IDR '.str_replace(",",".",number_format($this->data->orderheader[0]->vouchernominal)).'</div>
						</div>';
		}
		$action4 .= '<div style="margin-bottom: 5px; padding: 0 20px;">
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px;">SHIPPING FEE</div>
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; text-align: right;">IDR '.str_replace(",",".",number_format($this->data->orderheader[0]->shippingfee)).'</div>
						</div>
						<div style="padding: 0 20px;">
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px;">TAX</div>
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; text-align: right;">IDR '.str_replace(",",".",number_format($this->data->orderheader[0]->tax)).'</div>
						</div>';
		$action4 .= '</div>
					<div style="margin-bottom: 30px; background: #424242;">
						<div style="padding: 15px 20px;">
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: white; line-height: 25px;">TOTAL</div>
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: white; line-height: 25px; text-align: right;">IDR '.str_replace(",",".",number_format($this->data->orderheader[0]->subtotal - $this->data->orderheader[0]->vouchernominal + $this->data->orderheader[0]->conveniencefee + $this->data->orderheader[0]->shippingfee + $this->data->orderheader[0]->tax)).'</div>
						</div>
					</div>
			</div>
		</div>';

		$payment=array(
			"title"=>"REMINDER FOR YOUR ORDER"
			,"image"=>url('assets/images/icons/email-contact.png')
			,"body"=>$body
			,"action"=>$action.$action1.$action2.$action3.$action4
			,"actionText"=>""
		);
		return $this->view('email/defaultorder')->subject("Demor Boutique : Reminder for your order")->with("data",$payment);
    }
}
