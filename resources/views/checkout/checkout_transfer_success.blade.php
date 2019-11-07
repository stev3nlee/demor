@extends('layouts.master')

@section('title', 'Page Title')

@section('content')
	
	<div id="content" class="pad-checkout">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="title30 text-center">
						<div class="title">THANK YOU FOR SHOPPING</div>
						<div class="bdr-title"></div>
					</div>
					<div class="pos-rel order-top">
						<div class="bg-order"><img src="{{ url('assets/images/icons/box-order.png') }}" class="img-responsive" /></div>
						<div class="t-order">#{{$orderheader->orderno}}</div>
					</div>
					@if($orderheader->paymenttype == "Bank Transfer")
					<div class="txt-success">						
						<div>Please do the payment via bank transfer in the next 24 hours, after which we will release the order.</div>
						<div>Please confirm the payment in the <a href="{{ url('member/confirmpayment') }}">Member Area</a>.</div>				
					</div>
					@endif
					<div id="order-item" class="data-table detail-order">
						<div class="list header">
							<div>Item</div>
							<div class="w150 text-center hidden-xs">Price</div>
							<div class="w150 text-center hidden-xs">Quantity</div>
							<div class="w150 text-right hidden-xs">Total</div>
						</div>
						@php ($quantity = 0)
						@foreach($orderdetail as $detail)
						@php ($quantity += $detail->quantity)
						<div class="table-order">
							<div class="list items">
								<div class="w80">
									<img src="{{url($detail->productimage)}}" class="img-responsive" />
								</div>
								<div class="">
									<div class="in">
										<div>
											<div class="t-product">{{$detail->productname}}</div>
											<div class="txt-grey">
												<div class="clearfix mb10">
													<div class="pull-left w50">Color</div>
													<div class="pull-left color-cart">
														<img src="{{ url($detail->productcolor) }}" class="img-responsive" />
													</div>
												</div>
												<div class="clearfix mb10">
													<div class="pull-left w50">Size</div>
													<div class="pull-left">{{$detail->productsize}}</div>
												</div>
											</div>
										</div>
										<div class="w150 text-center hidden-xs">IDR {{str_replace(",",".",number_format($detail->productprice))}}</div>
										<div class="w150 text-center hidden-xs">{{$detail->quantity}}</div>
										<div class="w150 hidden-xs hidden-xs">IDR {{str_replace(",",".",number_format($detail->productprice * $detail->quantity))}}</div>								
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
									<div class="w35">IDR {{str_replace(",",".",number_format($detail->productprice))}}</div>
									<div class="w30 text-center">{{$detail->quantity}}</div>
									<div class="w35 text-right">IDR {{str_replace(",",".",number_format($detail->productprice * $detail->quantity))}}</div>								
								</div>
							</div>
						</div>
						@endforeach
						<div class="list items order-total-count">
							<div class="order-left">
								<div class="in mb10">
									<div class="sub-title w110">Voucher Code</div>
									<div class="w180">
										<input type="text" class="form-control input-order" name="promo" disabled value="{{ $orderheader->voucher }}"/>
									</div>
								</div>
							</div>
							<div class="">
								<div class="in mb10">
									<div class="sub-title">
										<div>SUBTOTAL</div>
										<div class="small">({{ $quantity }} Piece(s))</div>
									</div>
									<div class="w180">IDR {{ str_replace(",",".",number_format($orderheader->subtotal)) }}</div>
								</div>								
								<div class="in mb10">
									<div class="sub-title">SHIPPING FEE</div>
									<div class="w180">IDR {{ str_replace(",",".",number_format($orderheader->shippingfee)) }}</div>
								</div>
								<div class="in mb10">
									<div class="sub-title">
										<div>VOUCHER</div>
									</div>
									<div class="w180">IDR {{ str_replace(",",".",number_format($orderheader->vouchernominal)) }}</div>
								</div>
								<div class="in">
									<div class="sub-title">TAXES</div>
									<div class="w180">IDR {{str_replace(",",".",number_format( $orderheader->tax)) }}</div>
								</div>
								<div class="in">
									<div class="sub-title">ORDER TOTAL</div>
									<div class="w180">IDR {{ str_replace(",",".",number_format($orderheader->subtotal - $orderheader->vouchernominal + $orderheader->shippingfee + $orderheader->tax)) }}</div>
								</div>
								@if($orderheader->conveniencefee != 0)
								<div class="in">
									<div class="sub-title">CONVENIENCE FEE</div>
									<div class="w180">IDR {{ str_replace(",",".",number_format($orderheader->conveniencefee)) }}</div>
								</div>
								<div class="in">
									<div class="sub-title">GRAND TOTAL</div>
									<div class="w180">IDR {{ str_replace(",",".",number_format($orderheader->subtotal - $orderheader->vouchernominal + $orderheader->shippingfee + $orderheader->tax + $orderheader->conveniencefee)) }}</div>
								</div>
								@endif
							</div>
						</div>
					</div>
					<div class="bdr-submit"></div>
					<div class="title30 text-center mt60">
						<div class="title">ORDER DATA</div>
						<div class="bdr-title"></div>
					</div>
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Billing Info</div>
							<div class="m-name">
								<div>{{$orderinfo[1]->firstname}} {{$orderinfo[1]->lastname}}</div>
								<div>{{$orderinfo[1]->mobilenumber}}</div>
								<div>{{$orderinfo[1]->telphonenumber}}</div>
								<div>{{$orderinfo[1]->address}}</div>
								<div>{{$orderinfo[1]->city}}, {{$orderinfo[1]->zipcode}}</div>
								<div>{{$orderinfo[1]->state}}, {{$orderinfo[1]->country}}</div>
							</div>				
						</div>
						<div class="col-sm-5">
							<div class="m-title">Shipping Info</div>
							<div class="m-name">
								<div>{{$orderinfo[0]->firstname}} {{$orderinfo[0]->lastname}}</div>
								<div>{{$orderinfo[0]->mobilenumber}}</div>
								<div>{{$orderinfo[0]->telphonenumber}}</div>
								<div>{{$orderinfo[0]->address}}</div>
								<div>{{$orderinfo[0]->city}}, {{$orderinfo[0]->zipcode}}</div>
								<div>{{$orderinfo[0]->state}}, {{$orderinfo[0]->country}}</div>
							</div>
						</div>
					</div>
					<div class="row order40">
						<div class="col-sm-5 resp30">
							<div class="m-title">Payment</div>
							<div class="m-name">@if($orderheader->paymenttype == 'VT Web') Credit Card @else {{ $orderheader->paymenttype }} @endif</div>												
						</div>
						<div class="col-sm-5">
							<div class="m-title">Delivery</div>
							<div class="m-name">Regular</div>	
						</div>
					</div>
					<div class="row order80">
						<div class="col-sm-10">
							<div class="m-title">Notes</div>
							<div class="m-name">{{$orderheader->note}}</div>
						</div>
					</div>
					<div class="bdr-submit">
						<div class="text-center"><a href="{{ url('/') }}"><button type="button" class="btn btn-blue btn-auto">BACK TO HOME</button></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection