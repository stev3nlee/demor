<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailOrderRefund extends Mailable implements ShouldQueue
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
					</div>
					<div style="margin-bottom: 15px;">
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">STATUS ORDER </div>
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ITEM(S) IS NOT AVAILABLE</div>
					</div>
					<div style="margin-bottom: 15px;">
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PAYMENT STATUS</div>
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #3971ff; line-height: 25px; font-weight: bold;">REFUND MONEY</div>
					</div>
					<div>
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">SHIPPING STATUS</div>
						<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #ff4646; line-height: 25px; font-weight: bold;">CANCEL</div>
					</div>	';
		$action1 = ''; $action2 = ''; $action3 = ''; $action4 = '';

		if($this->data->orderheader[0]->paymenttype == 'Bank Transfer')
		{
			$body = '<div style="margin-bottom:15px;">Dear Customer,</div>
					<div style="margin-bottom:15px;">We do apologize to inform you that the item is not available. We will return your money including the shipping cost into your bank account within 5 working days.</div>
					<div>These are the following details of your order:</div>';
		}
		else if($this->data->orderheader[0]->paymenttype == 'VT Web')
		{
			$body = '<div style="margin-bottom:15px;">Dear Customer,</div>
					<div style="margin-bottom:15px;">We do apologize to inform you that the item is not available. We will return your money including the shipping cost and excluding the convenience fee into your credit card within 7 to 14 working days.</div>
					<div>These are the following details of your order: </div>';
		}

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
							<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PAYMENT METHOD</div>';
		if($this->data->orderheader[0]->paymenttype == 'Bank Transfer')
		{
			$action1 .= '<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">Bank Transfer</div>';
		}
		else if($this->data->orderheader[0]->paymenttype == 'VT Web')
		{
			$action1 .= '<div style="display:inline-block; width: 190px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 25px;">Credit Card</div>';
		}
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

		foreach($this->data->orderrefund as $orderdetail){
			$action2 .= '<div style="margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #c6c6c6;">
							<div style="display:inline-block; width: 80px; margin-right: 20px; vertical-align:top;">
								<img src="'.$orderdetail->productimage.'" style="width:80px;"/>
							</div>
							<div style="display:inline-block; width: 170px; margin-right: 10px; margin-top: -5px;">
							<div style="font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 15px; color: #424242; font-weight: bold; line-height: 25px; margin-bottom: 2px;">'.$orderdetail->productname.'</div>
							<div style="font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 13px; color: #757575; font-style: italic; line-height: 25px; margin-bottom: 5px;">IDR '.str_replace(",",".",number_format($orderdetail->productprice)).'</div>
							<div style="font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 13px; color: #757575; margin-bottom: 5px;">
								<div style="display: inline-block; width: 60px; vertical-align: top;">Color</div>
								<div style="display: inline-block; width: 100px;">
									<img src="http://'.$_SERVER['SERVER_NAME']."/".$orderdetail->productcolor.'" style="width: 12px; position: relative; top: 3px;"/>
								</div>
							</div>
							<div style="font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 13px; color: #757575; margin-bottom: 5px;">
								<div style="display: inline-block; width: 60px;">Size</div>
								<div style="display: inline-block; width: 100px;">'.$orderdetail->productsize.'</div>
							</div>
							<div style="font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 13px; color: #757575;">
								<div style="display: inline-block; width: 60px;">Qty</div>
								<div style="display: inline-block; width: 100px;">'.$orderdetail->quantity.'</div>
							</div>
						</div>
						<div style="display:inline-block; width: 110px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; text-align: right; font-weight: bold;">IDR '.str_replace(",",".",number_format(($orderdetail->productprice * $orderdetail->quantity))).'</div>
					</div>';
		}
		$shipping = 0;
		if($this->data->calculatepermit->shippingfee == true)
			$shipping = $this->data->orderheader[0]->shippingfee;
		if($this->data->orderheader[0]->voucherid != 0){
			$action3 .= '<div style="margin-bottom: 30px;">
						<div style="margin-bottom: 5px; padding: 0 20px;">
							<div style="display:inline-block; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px;">You have ordered using this voucher ('.$this->data->orderheader[0]->voucher.') IDR '.str_replace(",",".",number_format($this->data->orderheader[0]->vouchernominal)).'</div>			
						</div>
					</div>';
		}
		$action3 .= '<div style="margin-bottom: 30px;">
						<div style="margin-bottom: 5px; padding: 0 20px;">
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px;">SUBTOTAL</div>
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; text-align: right;">IDR '.str_replace(",",".",number_format($this->data->calculatepermit->subtotal)).'</div>
						</div>
					<div style="margin-bottom: 5px; padding: 0 20px;">
						<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #ff4646; line-height: 25px;">SHIPPING FEE</div>
						<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #ff4646; line-height: 25px; text-align: right;">IDR '.str_replace(",",".",number_format($shipping)).'</div>
					</div>';
		$action4 .= '</div>
					<div style="margin-bottom: 30px; background: #424242;">
						<div style="padding: 15px 20px;">
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: white; line-height: 25px;">TOTAL</div>
							<div style="display:inline-block; width: 175px; font : 300 14px/18px \'Lucida Grande\', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: white; line-height: 25px; text-align: right;">IDR '.str_replace(",",".",number_format($this->data->calculatepermit->subtotal - $this->data->orderheader[0]->vouchernominal + $shipping)).'</div>
						</div>
					</div>
			</div>
		</div>';

		$payment=array(
			"title"=>"Thank you"
			,"image"=>url('assets/images/icons/email-contact.png')
			,"body"=>$body
			,"action"=>$action.$action1.$action2.$action3.$action4
			,"actionText"=>""
		);
		return $this->view('email/defaultorder')->subject("Demor Boutique : Your order has refunded")->with("data",$payment);
    }
}
