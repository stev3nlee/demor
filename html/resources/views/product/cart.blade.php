@extends('layouts.master')

@section('title', 'Page Title')

@section('content')
	<script>
	var  vouchers = {};
	function DoPost(){
		$.post( "{{ url('checkout/validatevoucher') }}", { _token: "{{ csrf_token() }}", voucher: vouchers}, function(data) {
			console.log(data);
			if(data.success == true)
			{
				window.location.href = "{{url('checkout')}}";
			}
			else if(data.success == false && data.validation.length > 0)
			{
				$('input, textarea').removeClass('error');
				$('.form-error').html('');
				for(var i = 0; i < data.validation.length; i++)
				{
					$('[name='+data.validation[i].form+']').addClass('error');

					for(var j = 0; j < data.validation[i].msg.length; j++){
						$('#'+data.validation[i].form+'FormError').html($('#'+data.validation[i].form+'FormError').html()+data.validation[i].msg[j]);
					}
				}
				$("[name=voucher]").prop('disabled', false);
			}
			else
			{
				window.location.href = "{{url('checkout')}}";
			}
		});
	}

	$(document).ready(function() {
		$('.deleteClick').click(function(e){
			e.preventDefault();
			var url = '/'+$(this).attr('data-id')+'/'+$(this).attr('data-color')+'/'+$(this).attr('data-size');
			$('#deteleHref').attr('href', "{{ url('product/deletecart') }}"+url);
		});

		function recalculate(voucher)
		{
			var subtotal = ({{$general->cartinfo == null ? 0 : $general->cartinfo->Header->subtotal }});
			var vouchernominal = ({{$general->cartinfo == null ? 0 : $general->cartinfo->Header->vouchernominal }});
			var shipping = ({{$general->cartinfo == null ? 0 : $general->cartinfo->Header->shipping }});
			var tax = ({{$general->cartinfo == null ? 0 : $general->cartinfo->Header->tax }});
			var grandtotal = ({{$general->cartinfo == null ? 0 : $general->cartinfo->Header->subtotal + $general->cartinfo->Header->shipping + $general->cartinfo->Header->tax }});
			$('#spanSubtotal').html(subtotal);
			$('#spanVoucher').html(voucher.discount);
			$('#spanShipping').html(shipping);
			$('#spanTax').html(tax);
			if(grandtotal - voucher.discount < 0)
				$('#spanGrandtotal').html(0);
			else
				$('#spanGrandtotal').html(grandtotal - voucher.discount);
			vouchers = voucher;
			$('.select-currency').trigger('change');
			//$('.myNum').number(true,0,",",".");
		}

		$('[name=voucher]').blur(function(e){
			e.preventDefault();
			$('input, textarea').removeClass('error');
			$('.form-error').html('');

			$.ajax({
				type: "post",
				url: "{{ url('checkout/submitvoucher') }}",
				data: $("#submitVoucher").serialize(),
				dataType: 'json',
				success: function (data) {
					if(data.success == false)
					{
						for(var i = 0; i < data.validation.length; i++)
						{
							$('[name='+data.validation[i].form+']').addClass('error');

							for(var j = 0; j < data.validation[i].msg.length; j++){
								$('#'+data.validation[i].form+'FormError').html($('#'+data.validation[i].form+'FormError').html()+data.validation[i].msg[j]);
							}
						}
					}
					else if(data.success == 'not-member')
					{
						window.location.href = "{{url('login')}}";
					}
					else{
						$.fancybox.open({
							href: '#success',
						});
						$("[name=voucher]").prop('disabled', true);
					}
					recalculate(data.vouchers);
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});

		$('[name=quantity]').change(function(e){
			/*
			qty = $(this).val();
			price = $(this).parent().parent().parent().find('.price-quantity').find('.price').html();
			$(this).parent().parent().parent().find('.total-price').find('.total').html(price*qty);

			var subtotal=0;
			$('.total').each(function(){
				subtotal += parseInt($(this).html());
			})
			$('.subtotal').html(subtotal);

			var tax=0;
			$('.total').each(function(){
				tax += parseInt($(this).html())*10/100;
			})

			$('.tax-value').html(tax);
			shipping = $('.shipping-value').html()
			$('.grandtotal').html(parseInt(subtotal)+parseInt(tax)+parseInt(shipping))
			*/
			e.preventDefault();
			var qty = $(this).val();
			var order = {{$general->cartcount}};
			if(parseInt(qty) + parseInt(order) > 4)
			{
				$('#failedMessage').html('Sorry, you only can buy max 4 pieces for one transaction.');
				$.fancybox.open({
					href: '#failed',
				});
				window.location.href = "{{url('cart')}}";
				return;
			}
			var obj = {'_token':'{{csrf_token()}}', 'productId':$(this).attr('data-id'), 'productColor':$(this).attr('data-color'),'productSize':$(this).attr('data-size'),'productQuantity':$(this).val()};
			$.ajax({
				type: "post",
				url: "{{ url('product/addtocart') }}",
				data: obj,
				dataType: 'json',
				success: function (data) {
					console.log(data);
					window.location.href = "{{url('cart')}}";
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});

		});
	});
	</script>

	@if(count($general->cart) != 0)
		<div id="content" class="box-date">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="title30 text-center">
							<div class="title">SHOPPING BAG</div>
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
											<a href="{{url('product/detail/'.$cart->productId)}}"><img src="{{url($cart->productImage)}}" class="img-responsive" /></a>
										</div>
										<div class="">
											<div class="in">
												<div>
													<div class="t-product"><a href="{{url('product/detail/'.$cart->productId)}}">{{$cart->productName}}</a></div>
													<div class="txt-grey">
														<div class="clearfix mb10">
															<div class="pull-left w50">Color</div>
															<div class="pull-left color-cart">
																<img src="{{url($cart->productColorPath)}}" class="img-responsive" />
															</div>
														</div>
														<div class="clearfix mb10">
															<div class="pull-left w50">Size</div>
															<div class="pull-left">{{$cart->productSize}}</div>
														</div>
														@if($cart->productStock != 0)
															<div class="stock">IN STOCK </div>
														@else
															<div class="outstock">OUT OF STOCK</div>
														@endif
														<!--<div class="link-detail"><a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/product/detail.php">EDIT DETAILS</a></div>-->
														<a class="fancybox deleteClick" href="#delete" style="display: block;" data-id="{{$cart->productId}}" data-color="{{$cart->productColor}}" data-size="{{$cart->productSize}}"><div class="qdel">REMOVE</div></a>
													</div>
												</div>

												<div class="w150 text-center hidden-xs price-quantity">{{-- IDR <span class="price">{{str_replace(",",".",number_format($cart->productPrice))}}</span> --}}
													<span class="selected-currency">IDR</span>
													<span class="default-price-hidden hide">{{ $cart->productPrice }}</span>
													<span class="sale selected-currency-value total">{{ $cart->productPrice }}</span>
												</div>
												<div class="w150 text-center hidden-xs">
													<div class="custom-select w75">
														<div class="replacement">{{$cart->productQuantity}}</div>
														<select class="custom-select" name="quantity" onChange="custom_select(this)" data-id="{{$cart->productId}}" data-color="{{$cart->productColor}}" data-size="{{$cart->productSize}}">
															<option>Select Quantity</option>
															@for($i=0; $i < $cart->productStock; $i++)
																<option value="{{$i+1}}">{{$i+1}}</option>
															@endfor
														</select>
													</div>
												</div>
												<div class="w150 hidden-xs hidden-xs total-price">{{-- IDR <span class="total">{{str_replace(",",".",number_format($cart->productPrice * $cart->productQuantity))}} </span>--}}
													<span class="selected-currency">IDR</span>
													<span class="default-price-hidden hide">{{ $cart->productPrice * $cart->productQuantity }}</span>
													<span class="sale selected-currency-value total">{{ $cart->productPrice * $cart->productQuantity }}</span>
												</div>
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
											<div class="w35">{{-- IDR {{str_replace(",",".",number_format($cart->productPrice))}} --}}
												<span class="selected-currency">IDR</span>
												<span class="default-price-hidden hide">{{ $cart->productPrice }}</span>
												<span class="sale selected-currency-value">{{ $cart->productPrice }}</span>
											</div>
											<div class="w30 text-center">
												<div class="custom-select w75">
													<div class="replacement">{{$cart->productQuantity}}</div>
													<select class="custom-select" name="quantity" onChange="custom_select(this)">
														@for($i=0; $i < $cart->productStock; $i++)
															<option value="{{$i+1}}">{{$i+1}}</option>
														@endfor
													</select>
												</div>
											</div>
											<div class="w35 text-right">{{-- IDR {{str_replace(",",".",number_format($cart->productPrice * $cart->productQuantity))}} --}}
												<span class="selected-currency">IDR</span>
												<span class="default-price-hidden hide">{{ $cart->productPrice * $cart->productQuantity }}</span>
												<span class="sale selected-currency-value">{{ $cart->productPrice * $cart->productQuantity }}</span>
											</div>
										</div>
									</div>
								</div>
							@endforeach
							<div class="list items order-total-count">
								<div class="order-left">
									<form method="post" id="submitVoucher" onSubmit="return false">
										<div class="in">
											<div class="sub-title w110">Voucher Code</div>
											<div class="w180">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<input type="text" class="form-control input-order" name="voucher"/>
												<div class="form-error" id="voucherFormError"></div>
											</div>
										</div>
										<div class="in">
											<div class="w110"></div>
											<div class="w180">
												<div class="form-error" id="voucherFormError"></div>
											</div>
										</div>
									</form>
								</div>
								<div class="">
									<div class="in mb10">
										<div class="sub-title">
											<div>SUBTOTAL</div>
											<div class="small">({{$general->cartcount}} Piece(s))</div>
										</div>
										<div class="w180" id="subtotal">{{-- IDR <span class="subtotal myNum" id="spanSubtotal">@if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->subtotal)) }} @endif</span>--}}
											<span class="selected-currency">IDR</span>
											<span class="subtotal myNum">
												@if(str_replace(",",".",number_format($general->cartinfo == null)))
													0
												@else
													<span class="default-disc-price-hidden hide" id="spanSubtotal">{{ $general->cartinfo->Header->subtotal }}</span>
													<span class="bsale selected-disc-currency-value">{{ $general->cartinfo->Header->subtotal }}</span>
												@endif
											</span>
										</div>
									</div>
									<div class="in mb10">
										<div class="sub-title">
											<div>VOUCHER</div>
										</div>
										<div class="w180" id="voucher">{{-- IDR <span class="subtotal myNum" id="spanVoucher">@if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->vouchernominal)) }} @endif</span>--}}
											<span class="selected-currency">IDR</span>
											<span class="subtotal myNum" >
												@if(str_replace(",",".",number_format($general->cartinfo == null)))
													0
												@else
													<span class="default-disc-price-hidden hide" id="spanVoucher">{{ $general->cartinfo->Header->vouchernominal }}</span>
													<span class="bsale selected-disc-currency-value">{{ $general->cartinfo->Header->vouchernominal }}</span>
												@endif
											 </span>
										</div>
									</div>
									<div class="in">
										<div class="sub-title">TAXES</div>
										<div class="w180" id="tax">{{-- IDR <span class="tax-value myNum" id="spanTax">@if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->tax)) }} @endif</span> --}}
											<span class="selected-currency">IDR</span>
											<span class="tax-value myNum">
											 @if(str_replace(",",".",number_format($general->cartinfo == null)))
												0
											 @else
												 <span class="default-disc-price-hidden hide" id="spanTax">{{ $general->cartinfo->Header->tax }}</span>
												 <span class="bsale selected-disc-currency-value">{{ $general->cartinfo->Header->tax }}</span>
											 @endif
										 </span>
										</div>
									</div>
									<div class="in">
										<div class="sub-title">ORDER TOTAL</div>
										<div class="w180" id="grandtotal">{{-- IDR <span class="grandtotal myNum" id="spanGrandtotal">@if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->subtotal - $general->cartinfo->Header->vouchernominal + $general->cartinfo->Header->tax)) }} @endif</span> --}}
											<span class="selected-currency">IDR</span>
											<span class="grandtotal myNum">
												@if(str_replace(",",".",number_format($general->cartinfo == null)))
													0
												@else
													<span class="default-disc-price-hidden hide" id="spanGrandtotal">{{ $general->cartinfo->Header->subtotal - $general->cartinfo->Header->vouchernominal + $general->cartinfo->Header->tax }}</span>
 													<span class="bsale selected-disc-currency-value">{{ $general->cartinfo->Header->subtotal - $general->cartinfo->Header->vouchernominal + $general->cartinfo->Header->tax }}</span>
												@endif
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="btn-max bdr-submit">
							<div class="row">
								<div class="col-sm-4 col-sm-push-8 col-md-3 col-md-push-9">
									<a href="javascript:DoPost()"><button type="button" class="btn btn-blue max">CHECKOUT</button></a>
								</div>
								<div class="col-sm-4 col-sm-pull-4 col-md-3 col-md-pull-3">
									<a href="{{ url('product/arrival') }}">
										<div class="h40">
											<div class="tbl">
												<div class="cell">
													<div class="btn-back">CONTINUE SHOPPING</div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@else
		<div id="content">
			<div class="container">
				<div class="min400 center">
					<div class="tbl">
						<div class="cell">
							<div class="text-center">
								<div class="mb30">
									<div class="title">SHOPPING BAG</div>
									<div class="bdr-title"></div>
								</div>
								<div class="text-faq mb30">An order must have at least one item. Your order is empty.</div>
								<a href="{{ url('product/arrival') }}">
									<div class="btn-back">GO SHOPPING</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif

	<!-- Delete -->
	<div id="delete" class="width-pop">
		<div class="pad-pop">
			<div class="img-pop">
				<img src="{{url('assets/images/icons/delete.svg')}}" class="img-responsive"/>
			</div>
			<div class="text-pop mb30">Are you sure want to delete this item ?</div>
			<div class="clearfix text-center">
				<div class="inline-block mr25">
					<a id="deteleHref" href="{{ url('product/deletecart') }}"><button type="button" class="btn btn-blue">Delete</button></a>
				</div>
				<div class="inline-block">
					<button type="button" class="btn btn-red close-fancy">No</button>
				</div>
			</div>
		</div>
	</div>

@endsection
