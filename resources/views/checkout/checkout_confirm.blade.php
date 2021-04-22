@extends('layouts.master')

@section('title', 'Page Title')

@section('content')
	<script>
		function DoPost(btn){
			$(btn).prop('disabled', true);
			$(btn).val("Please Wait..");
			$.post( "{{url('checkout/transfer/submit')}}", { _token: "{{ csrf_token() }}"}, function(data) {
				if(data.success == true)
				{
					window.location.href = "{{url('checkout/transfersuccess')}}"+'/'+data.orderNo;
				}else{
					$(btn).prop('disabled', true);
					$(btn).val("SUBMIT");
				}
			});
	   }
	</script>

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
										<input type="text" class="form-control input-order" name="promo" value="{{ $general->cartinfo->Header->voucher }}" disabled/>
									</div>
								</div>
							</div>
							<div class="">
								<div class="in mb10">
									<div class="sub-title">
										<div>SUBTOTAL</div>
										<div class="small">({{$general->cartcount}} Piece(s))</div>
									</div>
									<div class="w180">IDR @if($general->cartinfo == null) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->subtotal)) }} @endif</div>
								</div>
								<div class="in mb10">
									<div class="sub-title">SHIPPING FEE</div>
									<div class="w180">IDR @if($general->cartinfo == null) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->shipping)) }} @endif</div>
								</div>
								<div class="in mb10">
									<div class="sub-title">
										<div>VOUCHER</div>
									</div>
									<div class="w180">IDR @if($general->cartinfo == null) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->vouchernominal)) }} @endif</div>
								</div>
								<div class="in">
									<div class="sub-title">TAXES</div>
									<div class="w180">IDR @if($general->cartinfo == null) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->tax)) }} @endif</div>
								</div>
								<div class="in">
									<div class="sub-title">ORDER TOTAL</div>
									<div class="w180">IDR @if($general->cartinfo == null) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->subtotal - $general->cartinfo->Header->vouchernominal + $general->cartinfo->Header->shipping + $general->cartinfo->Header->tax)) }} @endif</div>
								</div>
							</div>
						</div>
					</div>
					<div class="bdr-submit"></div>
					<div class="title30 text-center mt60">
						<div class="title">ORDER CONFIRMATION</div>
						<div class="bdr-title"></div>
					</div>
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Billing Info</div>
							<div class="m-name">
								<div>{{$general->cartinfo->Billing->fname}} {{$general->cartinfo->Billing->lname}}</div>
								<div>{{$general->cartinfo->Billing->mobileNumber}}</div>
								<div>{{$general->cartinfo->Billing->telephoneNumber}}</div>
								<div>{{$general->cartinfo->Billing->address}}</div>
								<div>@if($general->cartinfo->Billing->country != '102'){{$general->cartinfo->Billing->city}}@else{{$data->bcity[0]->name}}@endif, {{$general->cartinfo->Billing->zipcode}}</div>
								<div>@if($general->cartinfo->Billing->country != '102'){{$general->cartinfo->Billing->state}}@else{{$data->bstate[0]->name}}@endif, {{$data->bcountry[0]->name}}</div>
							</div>
						</div>
						<div class="col-sm-5">
							<div class="m-title">Shipping Info</div>
							<div class="m-name">
								<div>{{$general->cartinfo->Shipping->bfname}} {{$general->cartinfo->Shipping->blname}}</div>
								<div>{{$general->cartinfo->Shipping->bmobileNumber}}</div>
								<div>{{$general->cartinfo->Shipping->btelephoneNumber}}</div>
								<div>{{$general->cartinfo->Shipping->baddress}}</div>
								<div>@if($general->cartinfo->Shipping->bcountry != '102'){{$general->cartinfo->Shipping->bcity}}@else{{$data->scity[0]->name}}@endif, {{$general->cartinfo->Shipping->bzipcode}}</div>
								<div>@if($general->cartinfo->Shipping->bcountry != '102'){{$general->cartinfo->Shipping->bstate}}@else{{$data->sstate[0]->name}}@endif, {{$data->scountry[0]->name}}</div>
							</div>
						</div>
					</div>
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Payment</div>
							<div class="m-name">Bank Transfer</div>
						</div>
						<div class="col-sm-5">
							<div class="m-title">Delivery</div>
							<div class="m-name">Regular</div>
						</div>
					</div>
					<div class="row order80">
						<div class="col-sm-10">
							<div class="m-title">Notes</div>
							<div class="m-name">{{$general->cartinfo->Header->note}}</div>
						</div>
					</div>
					<div class="bdr-submit">
						<div class="text-center">
							<div class="mb20"><input type="button" onclick="DoPost(this)" class="btn btn-blue btn120 btn_sumbit_checkout" value="CONTINUE"></div>
							<div><a href="{{ url('checkout/payment') }}"><div class="btn-back">BACK</div></a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
