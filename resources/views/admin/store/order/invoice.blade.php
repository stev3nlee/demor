<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>De'mor Boutique</title>
	
	<link rel="icon" type="image/ico" href="{{URL::asset('adminassets/uploads/favicon.ico')}}">
	
	<!-- CSS -->
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/css/bootstrap.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/css/fonts.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/css/web.css')}}">
	
</head>
<body style="padding-top: 50px;">

<style>
.table10 { float: left; width: 10%; color: white !important; font-size: 14px; background: #64336e !important; border-right: 1px solid #999999; padding: 12px 15px; }
.table20 { float: left; width: 20%; color: white !important; font-size: 12px; background: #64336e !important; border-right: 1px solid #999999; padding: 12px 15px; }
.table20.fz14 { font-size: 14px; }
.table30 { float: left; width: 30%; color: white !important; font-size: 12px; background: #64336e !important; border-right: 1px solid #999999; padding: 12px 15px; }
.table50 { float: left; width: 50%; color: white !important; font-size: 14px; background: #64336e !important; padding: 12px 15px; }
.table10.bg-white, .table20.bg-white, .table30.bg-white, .table50.bg-white { color: #2b2b2b !important; background: white !important; }
</style>

	<div style="width: 100%; background: white;">
		<div class="container">
			<img src="{{ url('adminassets/images/test2.png') }}" style="width: 140px; margin-bottom: 20px;"/>
			<div class="row">
				<div class="col-xs-6">					
					<div style="font-size: 12px; line-height: 18px; color: #2b2b2b; ">
						<div>
							De'mor Boutique
						</div>
						<div>
							{!!$contact->address!!}
						</div>
						<div>{{$contact->email}}</div>
						<div>www.demorboutique.com</div>
					</div>					
				</div>
				<div class="col-xs-6">
					<div style="height: 108px; margin: auto 0;">
						<div class="tbl">
							<div class="cell">
								<div style="text-align: right; color: #64336e !important; font-size: 24px; letter-spacing: 1px;">INVOICE</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="margin: 50px 0;">
				<div style="border-bottom: 1px solid #999999;">
					<div class="clearfix" style="border-bottom: 1px solid #999999;">
						<div class="table20">ORDER DATE</div>
						<div class="table20">ORDER NO.</div>
						<div class="table30">PAYMENT METHOD</div>
						<div class="table30" style="border-right: 0;">SHIPPING METHOD</div>
					</div>
					<div class="clearfix">
						<div class="table20 bg-white" style="border-left: 1px solid #999999;">{{ $orderheader->insertdate }}</div>
						<div class="table20 bg-white">{{ $orderheader->orderno }}</div>
						<div class="table30 bg-white">@if($orderheader->paymenttype == 'VT Web') Credit Card @else {{ $orderheader->paymenttype }} @endif</div>
						<div class="table30 bg-white">Regular</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">					
					<div style="font-size: 14px; line-height: 21px; color: #2b2b2b; ">
						<div style="font-weight: bold;">BILLING ADDRESS</div>
						<div>{{$orderinfo[1]->firstname.' '.$orderinfo[1]->lastname}}</div>
						<div>{{$orderinfo[1]->address}}</div>
						<div>{{$orderinfo[1]->city}} {{$orderinfo[1]->zipcode}}</div>
						<div>{{$orderinfo[1]->state}}, {{$orderinfo[1]->country}}</div>
						<div>{{$orderinfo[1]->telphonenumber}}</div>
					</div>					
				</div>
				<div class="col-xs-6">					
					<div style="font-size: 14px; line-height: 21px; color: #2b2b2b; ">
						<div style="font-weight: bold;">SHIPPING ADDRESS</div>
						<div>{{$orderinfo[0]->firstname.' '.$orderinfo[0]->lastname}}</div>
						<div>{{$orderinfo[0]->address}}</div>
						<div>{{$orderinfo[0]->city}} {{$orderinfo[0]->zipcode}}</div>
						<div>{{$orderinfo[0]->state}}, {{$orderinfo[0]->country}}</div>
						<div>{{$orderinfo[1]->telphonenumber}}</div>
					</div>					
				</div>
			</div>
			<div style="margin: 50px 0;">
				<div>
					<div class="clearfix" style="border-bottom: 1px solid #999999;">
						<div class="table50">Item</div>
						<div class="table20 fz14" style="border-left: 1px solid #999999;">Price</div>
						<div class="table10">Qty.</div>
						<div class="table20 fz14" style="border-right: 0;">Total</div>
					</div>
					@foreach($orderdetail as $detail)
					<div class="clearfix" style="border-bottom: 1px solid #999999; border-left: 1px solid #999999; border-right: 1px solid #999999;">
						<div style="float: left; width: 50%; color: #2b2b2b; font-size: 14px; padding: 12px 15px;">{{$detail->productname}}</div>
						<div style="float: left; width: 20%; color: #2b2b2b; font-size: 14px; border-left: 1px solid #999999; padding: 12px 15px;">IDR {{str_replace(",",".",number_format($detail->productprice))}}</div>
						<div style="float: left; width: 10%; color: #2b2b2b; font-size: 14px; border-left: 1px solid #999999; padding: 12px 15px;">{{$detail->quantity}}</div>
						<div style="float: left; width: 20%; color: #2b2b2b; font-size: 14px; border-left: 1px solid #999999; padding: 12px 15px;">IDR {{str_replace(",",".",number_format($detail->productprice *  $detail->quantity))}}</div>
					</div>
					@endforeach
					<div class="clearfix" style="border-right: 1px solid #999999; border-left: 1px solid transparent;">
						<div style="float: right; width: 20%; color: #2b2b2b; font-size: 14px; padding: 8px 15px;">IDR {{ str_replace(",",".",number_format($orderheader->subtotal)) }}</div>
						<div style="float: right; width: 30%; color: #2b2b2b; font-size: 14px; border-right: 1px solid #999999; border-left: 1px solid #999999; padding: 8px 15px;">SUBTOTAL</div>
					</div>
					<div class="clearfix" style="border-right: 1px solid #999999; border-left: 1px solid transparent;">
						<div style="float: right; width: 20%; color: #2b2b2b; font-size: 14px; padding: 8px 15px;">IDR {{ str_replace(",",".",number_format($orderheader->shippingfee)) }}</div>
						<div style="float: right; width: 30%; color: #2b2b2b; font-size: 14px; border-right: 1px solid #999999; border-left: 1px solid #999999; padding: 8px 15px;">SHIPPING</div>
					</div>
					<div class="clearfix" style="border-right: 1px solid #999999; border-left: 1px solid transparent;">
						<div style="float: right; width: 20%; color: #2b2b2b; font-size: 14px; padding: 8px 15px;">IDR {{ str_replace(",",".",number_format($orderheader->vouchernominal)) }}</div>
						<div style="float: right; width: 30%; color: #2b2b2b; font-size: 14px; border-right: 1px solid #999999; border-left: 1px solid #999999; padding: 8px 15px;">VOUCHER CODE</div>
					</div>
					<div class="clearfix" style="border-right: 1px solid #999999; border-left: 1px solid transparent;">
						<div style="float: right; width: 20%; color: #2b2b2b; font-size: 14px; padding: 8px 15px;">IDR {{ str_replace(",",".",number_format($orderheader->tax)) }}</div>
						<div style="float: right; width: 30%; color: #2b2b2b; font-size: 14px; border-right: 1px solid #999999; border-left: 1px solid #999999; padding: 8px 15px;">TAXES</div>
					</div>
					<div class="clearfix" style="border-right: 1px solid #999999; border-left: 1px solid transparent;">
						<div style="float: right; width: 20%; color: #2b2b2b; font-size: 14px; padding: 8px 15px;">IDR {{ str_replace(",",".",number_format($orderheader->conveniencefee)) }}</div>
						<div style="float: right; width: 30%; color: #2b2b2b; font-size: 14px; border-right: 1px solid #999999; border-left: 1px solid #999999; padding: 8px 15px;">CONVENIENCE FEE</div>
					</div>
					
					<div class="clearfix">
						<div style="font-weight: bold; float: right; width: 20%; background: #64336e !important; color: white !important; font-size: 14px; padding: 12px 15px;">IDR {{ str_replace(",",".",number_format($orderheader->subtotal - $orderheader->vouchernominal + $orderheader->shippingfee + $orderheader->tax + $orderheader->conveniencefee)) }}</div>
						<div style="font-weight: bold; float: right; width: 30%; background: #64336e !important; color: white !important; font-size: 14px; border-right: 1px solid #999999; border-left: 1px solid #999999; padding: 12px 15px;">GRAND TOTAL</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>