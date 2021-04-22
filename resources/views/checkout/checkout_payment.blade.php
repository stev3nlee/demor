@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<div id="content" class="box-date pad-checkout">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="title30 text-center">
						<div class="title">YOUR PURCHASE</div>
						<div class="bdr-title"></div>
					</div>
					<div id="order-item" class="data-table detail-order">
						<div class="list header">
							<div>Item</div>
							<div class="w150 text-center hidden-xs">Price</div>
							<div class="w150 text-center hidden-xs">Quantity</div>
							<div class="w150 text-right hidden-xs">Total</div>
						</div>
						@foreach($general->cart as $cart)
						<div class="table-order">
							<div class="list items">
								<div class="w80">
									<img src="{{url($cart->productImage)}}" class="img-responsive" />
								</div>
								<div class="">
									<div class="in">
										<div>
											<div class="t-product">{{$cart->productName}}</div>
											<div class="txt-grey">
												<div class="clearfix mb10">
													<div class="pull-left w50">Color</div>
													<div class="pull-left color-cart">
														<img src="{{ url($cart->productColorPath) }}" class="img-responsive" />
													</div>
												</div>
												@if($cart->productLength)
												<div class="clearfix mb10">
													<div class="pull-left w50">Length</div>
													<div class="pull-left">{{$cart->productLength}}</div>
												</div>
												@endif
												<div class="clearfix mb10">
													<div class="pull-left w50">Size</div>
													<div class="pull-left">{{$cart->productSize}}</div>
												</div>
											</div>
										</div>
										<div class="w150 text-center hidden-xs">IDR {{str_replace(",",".",number_format($cart->productPrice))}}</div>
										<div class="w150 text-center hidden-xs">{{$cart->productQuantity}}</div>
										<div class="w150 hidden-xs hidden-xs">IDR {{str_replace(",",".",number_format($cart->productPrice * $cart->productQuantity))}}</div>
									</div>
								</div>
							</div>
							<div class="hidden-sm hidden-md hidden-lg">
								<div class="list header">
									<div class="w35">Price</div>
									<div class="w30 text-center">Qty</div>
									<div class="w35 text-right">Total</div>
								</div>
								<div class="list items">
									<div class="w35">IDR {{str_replace(",",".",number_format($cart->productPrice))}}</div>
									<div class="w30 text-center">{{$cart->productQuantity}}</div>
									<div class="w35 text-right">IDR {{str_replace(",",".",number_format($cart->productPrice * $cart->productQuantity))}}</div>
								</div>
							</div>
						</div>
						@endforeach
						<div class="list items order-total-count">
							<div class="order-left">
								<div class="in mb10">
									<div class="sub-title w110">Voucher Code</div>
									<div class="w180">
										<input type="text" class="form-control input-order" name="promo" value="{{ ($general->cartinfo == null ? '' : $general->cartinfo->Header->voucher) }}" disabled/>
									</div>
								</div>
							</div>
							<div class="">
								<div class="in mb10">
									<div class="sub-title">
										<div>SUBTOTAL</div>
										<div class="small">({{$general->cartcount}} Piece(s))</div>
									</div>
									<div class="w180">IDR @if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->subtotal)) }} @endif</div>
								</div>
								<div class="in mb10">
									<div class="sub-title">SHIPPING FEE</div>
									<div class="w180">IDR @if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->shipping)) }} @endif</div>
								</div>
								<div class="in mb10">
									<div class="sub-title">
										<div>VOUCHER</div>
									</div>
									<div class="w180">IDR @if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->vouchernominal)) }} @endif</div>
								</div>
								<div class="in">
									<div class="sub-title">TAXES</div>
									<div class="w180">IDR @if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->tax)) }} @endif</div>
								</div>
								<div class="in">
									<div class="sub-title">ORDER TOTAL</div>
									<div class="w180">@if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->subtotal - $general->cartinfo->Header->vouchernominal + $general->cartinfo->Header->shipping + $general->cartinfo->Header->tax)) }} @endif</div>
								</div>
							</div>
						</div>
					</div>
					<div class="bdr-submit"></div>
					<div class="title30 text-center mt60">
						<div class="title">PAYMENT</div>
						<div class="bdr-title"></div>
					</div>
					@php($cur = 0)
					<ul class="tab-payment">
						@foreach($paymenttype as $type)
							@if($type->paymentview == 'viewcredit' && $type->ispublish == 1)
							@php($cur = 1)
							<li class="tab-link current" data-tab="tab-1">
								<img src="{{ url('assets/images/icons/payment01.svg') }}" class="img-responsive" />
							</li>
							@elseif($type->paymentview == 'viewtransfer' && $type->ispublish == 1)
								@if($cur == 0) @php($cur = 2) @endif
							<li class="tab-link @if($cur == 2) current @endif" data-tab="tab-2">
								<img src="{{ url('assets/images/icons/payment02.svg') }}" class="img-responsive" />
							</li>
							@endif
						@endforeach
					</ul>
					<div id="tab-1" class="content-payment @if($cur == 1) current @endif">
						<div class="t-payment">PAYMENT VIA CREDIT CARD</div>
						<div class="txt-success mb0">Payment by Credit Card, price excludes convenience fee 3.2% + IDR 3.000 <br /> (non-refundable)</div>
						<div class="margin30">
							<div class="w-credit">
								<div class="inline w200">ORDER TOTAL</div>
								<div class="inline w200 text-right">IDR @if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->subtotal - $general->cartinfo->Header->vouchernominal + $general->cartinfo->Header->shipping + $general->cartinfo->Header->tax)) }} @endif</div>
							</div>
							<div class="w-credit">
								<div class="inline w200">CONVENIENCE FEE</div>
								<div class="inline w200 text-right">IDR @if ($general->cartinfo == null) 0 @else {{ str_replace(",",".",number_format((($general->cartinfo->Header->subtotal - $general->cartinfo->Header->vouchernominal + $general->cartinfo->Header->shipping + $general->cartinfo->Header->tax) * 3.2 / 100) + 3000)) }} @endif</div>
							</div>
							<div class="w-credit">
								<div class="inline w200">GRAND TOTAL</div>
								<div class="inline w200 text-right">IDR @if($general->cartinfo == null) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->subtotal - $general->cartinfo->Header->vouchernominal + $general->cartinfo->Header->shipping + $general->cartinfo->Header->tax + ((($general->cartinfo->Header->subtotal - $general->cartinfo->Header->vouchernominal + $general->cartinfo->Header->shipping + $general->cartinfo->Header->tax) * 3.2 / 100) + 3000))) }} @endif</div>
							</div>
						</div>
						<!--
						<div class="img-vt">
							<img src="{{ url('assets/images/icons/vt-web.jpg') }}" class="img-responsive" />
						</div>
						-->
						<div class="bdr-submit">
							<div class="text-center">
								<div class="mb20">
									<form action="{{ url('checkout/vtweb') }}" method="get" id="frmCheckout">
										<button type="button" id="btn_submit" class="btn btn-blue btn120">CONTINUE</button>
									</form>
								</div>
								<div><a href="{{ url('checkout') }}"><div class="btn-back">BACK</div></a></div>
							</div>
						</div>
					</div>
					<div id="tab-2" class="content-payment @if($cur == 2) current @endif">
						<div class="t-payment" style="margin-bottom: 10px;">PAYMENT VIA BANK TRANSFER</div>
						<div class="text-center" style="margin-bottom: 50px; font-size:17px;"> (Only for Indonesian) </div>
						@foreach($payments as $payment)
							<div class="b-payment">
								<div class="n-payment">Silahkan Transfer ke Account {{$payment->bankname}}</div>
								<div class="txt-payment">{{$payment->accountnumber}} A/N {{$payment->bankaccountname}}</div>
							</div>
						@endforeach
						<div class="bdr-submit">
							<div class="text-center">
								<div class="mb20">
									<form action="{{ url('checkout/confirm') }}" method="get" id="frmCheckout2">
										<button type="button" id="btn_submit2" class="btn btn-blue btn120">CONTINUE</button>
									</form>
								</div>
								<div><a href="{{ url('checkout') }}"><div class="btn-back">BACK</div></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
$('#btn_submit').click(function(){
	$(this).html("Please Wait...");
	$('#frmCheckout').submit();
})

$('#btn_submit2').click(function(){
	$(this).html("Please Wait...");
	$('#frmCheckout2').submit();
})
</script>
@endsection
