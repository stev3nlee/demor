<?php
class Mail {
	public $data = '';
	
	function getSubject($cons)
	{
		$subject = '';
		switch($cons){
			case 'forgot':
				$subject = 'De\'mor Forgot Password';
			break;
			case 'register':
				$subject = 'De\'mor Register Activation';
			case 'order':
				$subject = 'De\'mor Transaction Status';
			break;
			case 'orderAdmin':
				$subject = 'De\'mor Order';
			break;
		}
		return $subject;
	}
	function getBody($cons, $gendata)
	{
		$body = '';

		switch($cons){
			case 'forgot':
				ob_start();
				$data = $gendata;
				include "template/forgot.php";
				//$body = file_get_contents('template/forgot.php');
				$body = ob_get_contents();
			break;
			case 'register':
				ob_start();
				$data = $gendata;
				include "template/register.php";
				$body = ob_get_contents();
				ob_end_clean();
			break;
			case 'order':
				ob_start();
				$data = $gendata;
				include "template/payment.php";
				$body = ob_get_contents();
				ob_end_clean();
			break;
			case 'orderAdmin':
				ob_start();
				$data = $gendata;
				include "template/adminOrder.php";
				$body = ob_get_contents();
				ob_end_clean();
			break;
		}
		return $body;
	}
}