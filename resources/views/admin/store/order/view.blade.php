@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#order').addClass ('active');
	});
	</script>
		
	<div class="content">
		<div class="breadcrumb">
			@foreach($breadCrumb as $index => $b)
				@if($b->path == '')
					<span class="active">{{$b->name}}</span>
				@else
					<a href="{{ url($b->path) }}">{{$b->name}}</a>
				@endif
				@if($index != count($breadCrumb) - 1)
					<span class="m10"> > </span>
				@endif
			@endforeach
		</div>
		<div class="title">View Order Detail <span style="margin-left: 20px;">#{{ $orderheader->orderno }}</span></div>						
		<div class="content">
			<div id="tabs-container">
				<div class="clearfix">
					<div class="pull-left mr30" style="width: 170px;">
						<ul class="tabs-menu">
							<li class="current"><a href="#tab-1">Member</a></li>
							<li><a href="#tab-2">Billing</a></li>
							<li><a href="#tab-3">Shipping</a></li>
							<li><a href="#tab-6">Payment</a></li>
							@php ($i = 1)
                            @foreach($orderpayment as $payment)
                                <li><a href="#tab-{{ $i+6 }}">Payment {{ $i++ }}</a></li>
                            @endforeach
							<li><a href="#tab-4">Product</a></li>
							<li><a href="#tab-5">History</a></li>
						</ul>
						<div class="mb20">
							<a href="{{ url('meisjejongetje/commerce/invoice/'.$orderheader->orderno) }}" target="_blank"><button type="button" class="btn btn-pop" style="width: 125px; margin-top: 0;">INVOICE</button></a>
						</div>
						<div>
							<a href="{{ url('meisjejongetje/commerce/order') }}"><button type="button" class="btn btn-pop" style="width: 125px; margin-top: 0;">Back</button></a>
						</div>
					</div>
					<div class="pull-left">
						<div class="tab">
							<div id="tab-1" class="tab-content">
								<div class="t-code">Member</div>
								<div>
									<div class="t-order">Full Name</div>
									<div class="w-order">{{ $orderheader->membername }}</div>
								</div>
								<div class="border-title"></div>
								<div>
									<div class="t-order">Email</div>
									<div class="w-order">{{ $orderheader->memberemail }}</div>
								</div>
								<div class="border-title"></div>
								<div>
									<div class="t-order">Date of Birth</div>
									<div class="w-order">12/12/1990</div>
								</div>
								<div class="border-title"></div>
								<div class="mb20">
									<div class="t-order">Gender</div>
									<div class="w-order">Female</div>
								</div>
							</div>
							<div id="tab-2" class="tab-content">
								<div class="t-code">Billing</div>
								<div class="full-product">
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">First Name</p>
											<p>{{$orderinfo[1]->firstname}}</p>
										</div>
										<div class="wdth50">
											<p class="htitle">Last Name</p>
											<p>{{$orderinfo[1]->lastname}}</p>
										</div>
									</div>
									<div class="border-title"></div>
									<div>
										<div class="t-order">Email Address</div>
										<div class="w-order">{{$orderinfo[1]->email}}</div>
									</div>
									<div class="border-title"></div>
									<div>
										<div class="t-order">Address</div>
										<div class="w-order">{{$orderinfo[1]->address}}</div>
									</div>
									<div class="border-title"></div>
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">Country</p>
											<p>{{$orderinfo[1]->country}}</p>
										</div>
										<div class="wdth50">
											<p class="htitle">State</p>
											<p>{{$orderinfo[1]->state}}</p>
										</div>
									</div>
									<div class="border-title"></div>
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">City</p>
											<p>{{$orderinfo[1]->city}}</p>
										</div>
										<div class="wdth50">
											<p class="htitle">Zip Code</p>
											<p>{{$orderinfo[1]->zipcode}}</p>
										</div>
									</div>
									<div class="border-title"></div>
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">Telephone Number</p>
											<p>{{$orderinfo[1]->telphonenumber}}</p>
										</div>
										<div class="wdth50">
											<p class="htitle">Mobile Number</p>
											<p>{{$orderinfo[1]->mobilenumber}}</p>
										</div>
									</div>
								</div>
							</div>
							<div id="tab-3" class="tab-content">
								<div class="t-code">Shipping</div>
								<div class="full-product">
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">First Name</p>
											<p>{{$orderinfo[0]->firstname}}</p>
										</div>
										<div class="wdth50">
											<p class="htitle">Last Name</p>
											<p>{{$orderinfo[0]->lastname}}</p>
										</div>
									</div>
									<div class="border-title"></div>
									<div>
										<div class="t-order">Email Address</div>
										<div class="w-order">{{$orderinfo[0]->email}}</div>
									</div>
									<div class="border-title"></div>
									<div>
										<div class="t-order">Address</div>
										<div class="w-order">{{$orderinfo[0]->address}}</div>
									</div>
									<div class="border-title"></div>
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">Country</p>
											<p>{{$orderinfo[0]->country}}</p>
										</div>
										<div class="wdth50">
											<p class="htitle">State</p>
											<p>{{$orderinfo[0]->state}}</p>
										</div>
									</div>
									<div class="border-title"></div>
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">City</p>
											<p>{{$orderinfo[0]->city}}</p>
										</div>
										<div class="wdth50">
											<p class="htitle">Zip Code</p>
											<p>{{$orderinfo[0]->zipcode}}</p>
										</div>
									</div>
									<div class="border-title"></div>
									<div class="row clearfix">
										<div class="wdth50">
											<p class="htitle">Telephone Number</p>
											<p>{{$orderinfo[0]->telphonenumber}}</p>
										</div>
										<div class="wdth50">
											<p class="htitle">Mobile Number</p>
											<p>{{$orderinfo[0]->mobilenumber}}</p>
										</div>
									</div>
								</div>
							</div>
							<div id="tab-4" class="tab-content">										
								<div class="full-product">
									<div class="t-code">Product</div>
									<div class="mb30">
										<p class="htitle">Order Note</p>
										<p>{{ $orderheader->note }}</p>
									</div>
									<div class="table-role">
										<table style="width: 100% !important;">
											<thead>
												<tr>
													<td>Item</td>
													<td width="200" class="text-center">Price</td>
													<td width="200" class="text-center">Quantity</td>
													<td width="200" class="text-right">Total</td>
												</tr>
											</thead>
											<tbody>
												@foreach($orderdetail as $detail)
													<tr>
														<td>
															<div class="clearfix">
																<div class="pull-left mr20">
																	<div class="table-imgproduct">
																		<img src="{{url($detail->productimage)}}" class="img-responsive">
																	</div>
																</div>
																<div class="pull-left">
																	<div class="detail-product">{{$detail->productname}}</div>
																	<div class="s-title">
																		<div style="margin: 5px 0;"><div style="display: inline-block; position: relative; top: -6px; margin-right: 5px; ">Color : </div><div style="display: inline-block;"><img src="{{ url($detail->productcolor) }}" class="img-responsive"></div></div>
																		<div>Size : {{$detail->productsize}}</div>
																		@if($detail->productlength)<div>Length : {{$detail->productlength}}</div>@endif
																	</div>
																</div>
															</div>
														</td>
														<td class="text-center">IDR {{str_replace(",",".",number_format($detail->productprice))}}</td>
														<td class="text-center">{{$detail->quantity}}</td>
														<td class="text-right">IDR {{str_replace(",",".",number_format($detail->productprice *  $detail->quantity))}}</td>
													</tr>
												@endforeach
											</tbody>
											<tfoot>
												<tr>
													<td rowspan="1" colspan="2">
														<div class="clearfix">
															<div style="float: left; margin-right: 10px; position: relative; top: 3px;">PROMO CODE</div>
															<div style="width: 150px; float:left;">
																<input type="text" class="form-control" name="promo" disabled value="{{ $orderheader->voucher }}"/>
															</div>
														</div>
													</td>
													<td rowspan="1" colspan="2">
														<div class="text-right">
															<p> SUBTOTAL : IDR {{ str_replace(",",".",number_format($orderheader->subtotal)) }}</p>
															<p> VOUCHER : IDR {{ str_replace(",",".",number_format($orderheader->vouchernominal)) }}</p>
															<p> SHIPPING FEE : IDR {{ str_replace(",",".",number_format($orderheader->shippingfee)) }} </p>
															<p> TAXES : IDR {{ str_replace(",",".",number_format($orderheader->tax)) }} </p>
															<p> CONVENIENCE FEE : IDR {{ str_replace(",",".",number_format($orderheader->conveniencefee)) }} </p>
															<p> ORDER TOTAL : IDR {{ str_replace(",",".",number_format($orderheader->subtotal - $orderheader->vouchernominal + $orderheader->shippingfee + $orderheader->tax + $orderheader->conveniencefee)) }} </p>
														</div>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
							<div id="tab-5" class="tab-content">
								<div class="t-code">History</div>
								<div class="adminTable">
									<table id="table_id2" style="width: 100% !important;">
										<thead>
											<tr>
												<td>Date</td>
												<td>Payment</td>
												<td>Shipping</td>
											</tr>
										</thead>
										<tbody>
											@foreach($orderhistory as $history)
												<tr>
													<td>{{$history->date}}</td>
													@if($history->status == 'Pending')
														<td class="orange">Pending</td>
														<td class="orange">Pending</td>
													@elseif($history->status == 'Waiting')
														<td class="waiting red">Awaiting for payment</td>
														<td class="orange">Pending</td>
													@elseif($history->status == 'Paid')
														<td class="green">Paid</td>
														<td class="orange">On Process</td>
													@elseif($history->status == 'Ship')
														<td class="green">Paid</td>
														<td>
															<div class="green">Shipped</div>
															<div class="track">Track No. {{$history->remark}}</div>
														</td>
													@endif
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>	
							</div>
							<div id="tab-6" class="tab-content">
								<div class="t-code">Payment</div>
								<div>
									<div class="t-order">Payment Method</div>
									<div class="w-order">{{ $orderheader->paymenttype }}</div>
								</div>
								@if($orderheader->paymenttype == "Bank Transfer")
									<div class="border-title"></div>
									<div>
										<div class="t-order">Account No</div>
										<div class="w-order">{{ $orderheader->accountno }}</div>
									</div>
									<div class="border-title"></div>
									<div>
										<div class="t-order">Account Name</div>
										<div class="w-order">{{ $orderheader->accountname }}</div>
									</div>
									<div class="border-title"></div>
									<div>
										<div class="t-order">Payment To</div>
										<div class="w-order">{{ $orderheader->bankname.' '.$orderheader->accountnumber }}</div>
									</div>
									<div class="border-title"></div>
									<div>
										<div class="t-order">Image</div>
										@if(null != $orderheader->evidence)
										<div class="w-order">
											<img src="{{ url($orderheader->evidence) }}" class="img-responsive" style="width: 150px;">
										</div>
										@endif
									</div>
									<div class="border-title"></div>
									<div class="mb20">
										<div class="t-order">Total</div>
										<div class="w-order">IDR {{ str_replace(",",".",number_format($orderheader->totalamount)) }}</div>
									</div>
								@endif
							</div>
							@php ($i = 1)
							@foreach($orderpayment as $payment)
							<div id="tab-{{6 + $i++}}" class="tab-content">
								<div class="t-code">Payment</div>
								<div>
									<div class="t-order">Payment Method</div>
									<div class="w-order">Bank Transfer</div>
								</div>
								<div class="border-title"></div>
								<div>
									<div class="t-order">Account No</div>
									<div class="w-order">{{ $payment->accountno }}</div>
								</div>
								<div class="border-title"></div>
								<div>
									<div class="t-order">Account Name</div>
									<div class="w-order">{{ $payment->accountname }}</div>
								</div>
								<div class="border-title"></div>
								<div>
									<div class="t-order">Payment To</div>
									<div class="w-order">{{ $payment->bankname.' '.$payment->accountnumber }}</div>
								</div>
								<div class="border-title"></div>
								<div>
									<div class="t-order">Image</div>
									@if(null != $payment->evidence)
									<div class="w-order">
										<img src="{{ url($payment->evidence) }}" class="img-responsive" style="width: 150px;">
									</div>
									@endif
								</div>
								<div class="border-title"></div>
								<div class="mb20">
									<div class="t-order">Total</div>
									<div class="w-order">IDR {{ str_replace(",",".",number_format($payment->totalamount)) }}</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>					
		</div>
	</div>			

@endsection