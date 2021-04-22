@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		if($('[name=country]').val() == '102')
		{
			$('#state2').hide();
			$('#city2').hide();
			$('#postcode2').hide();
			$('#bstate2').hide();
			$('#bcity2').hide();
			$('#bpostcode2').hide();
		}
		else
		{
			$('#state').hide();
			$('#city').hide();
			$('#postcode').hide();
			$('#bstate').hide();
			$('#bcity').hide();
			$('#bpostcode').hide();
		}

		$('#submitInfo').submit(function(e){
			e.preventDefault();
			$('input, textarea').removeClass('error');
			$('.form-error').html('');
			$("#btnInfo").html('Please Wait...');
			$.ajax({
				type: "post",
				url: "{{ url('checkout/submitinfo') }}",
				data: $("#submitInfo").serialize(),
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
						$("#btnInfo").html('CONTINUE TO PAYMENT');
					}
					else{
						location.href = "{{url('checkout/payment')}}";
					}
				},
				error: function (data) {
					console.log('Error:', data);
					$("#btnInfo").html('CONTINUE TO PAYMENT');
				}
			});
		});

		$('[name=country]').change(function(e){
			var country = $(this).val();
			if(country == '102'){
				$('#state2').hide();
				$('#city2').hide();
				$('#postcode2').hide();
				$('#state').show();
				$('#city').show();
				$('#postcode').show();

				$.ajax({
					type: "get",
					url: "{{ url('member/state') }}"+"/"+country,
					data: $("#submitPersonal").serialize(),
					dataType: 'json',
					success: function (data) {
						$('[name=state]').find('option').remove();
						$('[name=state]').append($('<option>', {
							value: '',
							text : 'Select State'
						}));
						$('[name=city]').find('option').remove();
						$('[name=city]').append($('<option>', {
							value: '',
							text : 'Select City'
						}));
						$('[name=postcode]').find('option').remove();
						$('[name=postcode]').append($('<option>', {
							value: '',
							text : 'Select Post Code'
						}));
						for(var i = 0; i < data.states.length; i++)
						{
							$('[name=state]').append($('<option>', {
								value: data.states[i].id,
								text : data.states[i].name
							}));
						}
						$('[name=state]').val('').trigger('change.customSelect');
						$('[name=city]').val('').trigger('change.customSelect');
						$('[name=postcode]').val('').trigger('change.customSelect');
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			}
			else
			{
				$('#state2').show();
				$('#city2').show();
				$('#postcode2').show();
				$('#state2').val('');
				$('#city2').val('');
				$('#postcode2').val('');
				$('#state').hide();
				$('#city').hide();
				$('#postcode').hide();
			}
		});
		$('[name=bcountry]').change(function(e){
			var country = $(this).val();
			if(country == '102'){
				$('#bstate2').hide();
				$('#bcity2').hide();
				$('#bpostcode2').hide();
				$('#bstate').show();
				$('#bcity').show();
				$('#bpostcode').show();

				$.ajax({
					type: "get",
					url: "{{ url('member/state') }}"+"/"+country,
					data: $("#submitPersonal").serialize(),
					dataType: 'json',
					success: function (data) {
						$('[name=bstate]').find('option').remove();
						$('[name=bstate]').append($('<option>', {
							value: '',
							text : 'Select State'
						}));
						$('[name=bcity]').find('option').remove();
						$('[name=bcity]').append($('<option>', {
							value: '',
							text : 'Select City'
						}));
						$('[name=bpostcode]').find('option').remove();
						$('[name=bpostcode]').append($('<option>', {
							value: '',
							text : 'Select Post Code'
						}));
						for(var i = 0; i < data.states.length; i++)
						{
							$('[name=bstate]').append($('<option>', {
								value: data.states[i].id,
								text : data.states[i].name
							}));
						}
						$('[name=bstate]').val('').trigger('change.customSelect');
						$('[name=bcity]').val('').trigger('change.customSelect');
						$('[name=bpostcode]').val('').trigger('change.customSelect');
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			}
			else
			{
				$('#bstate2').show();
				$('#bcity2').show();
				$('#bpostcode2').show();
				$('#bstate2').val('');
				$('#bcity2').val('');
				$('#bpostcode2').val('');
				$('#bstate').hide();
				$('#bcity').hide();
				$('#bpostcode').hide();
			}
		});

		$('[name=state]').change(function(e){
			var state = $(this).val();
			$.ajax({
				type: "get",
				url: "{{ url('member/city') }}"+"/"+state,
				data: $("#submitPersonal").serialize(),
				dataType: 'json',
				success: function (data) {
					$('[name=city]').find('option').remove();
					$('[name=city]').append($('<option>', {
						value: '',
						text : 'Select City'
					}));
					$('[name=postcode]').find('option').remove();
					$('[name=postcode]').append($('<option>', {
						value: '',
						text : 'Select Post Code'
					}));
					for(var i = 0; i < data.cities.length; i++)
					{
						$('[name=city]').append($('<option>', {
							value: data.cities[i].id,
							text : data.cities[i].name
						}));
					}
					$('[name=city]').val('').trigger('change.customSelect');
					$('[name=postcode]').val('').trigger('change.customSelect');
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});
		$('[name=bstate]').change(function(e){
			var state = $(this).val();
			$.ajax({
				type: "get",
				url: "{{ url('member/city') }}"+"/"+state,
				data: $("#submitPersonal").serialize(),
				dataType: 'json',
				success: function (data) {
					$('[name=bcity]').find('option').remove();
					$('[name=bcity]').append($('<option>', {
						value: '',
						text : 'Select City'
					}));
					$('[name=bpostcode]').find('option').remove();
					$('[name=bpostcode]').append($('<option>', {
						value: '',
						text : 'Select Post Code'
					}));
					for(var i = 0; i < data.cities.length; i++)
					{
						$('[name=bcity]').append($('<option>', {
							value: data.cities[i].id,
							text : data.cities[i].name
						}));
					}
					$('[name=bcity]').val('').trigger('change.customSelect');
					$('[name=bpostcode]').val('').trigger('change.customSelect');
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});

		$('[name=city]').change(function(e){
			var city = $(this).val();
			$.ajax({
				type: "get",
				url: "{{ url('member/postcode') }}"+"/"+city,
				data: $("#submitPersonal").serialize(),
				dataType: 'json',
				success: function (data) {
					$('[name=postcode]').find('option').remove();
					$('[name=postcode]').append($('<option>', {
						value: '',
						text : 'Select Post Code'
					}));
					for(var i = 0; i < data.postcodes.length; i++)
					{
						$('[name=postcode]').append($('<option>', {
							value: data.postcodes[i].postal_code,
							text : data.postcodes[i].postal_code+' - '+data.postcodes[i].postal_name
						}));
					}
					$('[name=postcode]').val('').trigger('change.customSelect');
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});
		$('[name=bcity]').change(function(e){
			var city = $(this).val();
			$.ajax({
				type: "get",
				url: "{{ url('member/postcode') }}"+"/"+city,
				data: $("#submitPersonal").serialize(),
				dataType: 'json',
				success: function (data) {
					$('[name=bpostcode]').find('option').remove();
					$('[name=bpostcode]').append($('<option>', {
						value: '',
						text : 'Select Post Code'
					}));
					for(var i = 0; i < data.postcodes.length; i++)
					{
						$('[name=bpostcode]').append($('<option>', {
							value: data.postcodes[i].postal_code,
							text : data.postcodes[i].postal_code+' - '+data.postcodes[i].postal_name
						}));
					}
					$('[name=bpostcode]').val('').trigger('change.customSelect');
					$('#bpostcode').show();
					$('#bpostcode2').hide();
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});
	});
	</script>

	<div id="content" class="pad-checkout box-date">
		<div class="container">
			<form method="post" id="submitInfo">
				<div class="row">
					<div class="col-sm-7 col-lg-6 resp30">
						<div class="left-checkout">
							<div class="title mb30">BILLING ADDRESS</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>First Name <span class="pruple">*</span></label>
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="text" class="form-control" name="fname" value="{{$memberDetail->firstname}}" />
										<div class="form-error" id="fnameFormError"></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Last Name <span class="pruple">*</span></label>
										<input type="text" class="form-control" name="lname" value="{{$memberDetail->lastname}}" />
										<div class="form-error" id="lnameFormError"></div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Email Address <span class="pruple">*</span></label>
								<input type="text" class="form-control" name="email" value="{{$memberDetail->emailaddress}}" />
								<div class="form-error" id="emailFormError"></div>
							</div>
							<div class="form-group">
								<label>Address <span class="pruple">*</span></label>
								<input type="text" class="form-control" name="address" value="{{$memberDetail->address}}" />
								<div class="form-error" id="addressFormError"></div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Country <span class="pruple">*</span></label>
										<div class="custom-select">
											<div class="replacement">@if($memberDetail->country == null) Select Country @else {{$memberDetail->countryname}} @endif</div>
											<select class="custom-select" name="country" onChange="custom_select(this)">
												<option value="" selected disabled>Select Country</option>
												@foreach($countries as $country)
													<option value="{{ $country->id }}" @if($country->id == $memberDetail->country) selected @endif>{{ $country->name }}</option>
												@endforeach
											</select>
										</div>
										<div class="form-error" id="countryFormError"></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>State <span class="pruple">*</span></label>
										<div class="custom-select" id="state">
											<div class="replacement">@if($memberDetail->state == null) Select State @else {{$memberDetail->statename}} @endif</div>
											<select class="custom-select" name="state" onChange="custom_select(this)">
												<option value="" selected disabled>Select State</option>
												@foreach($states as $state)
													<option value="{{ $state->id }}" @if($state->id == $memberDetail->state) selected @endif>{{ $state->name }}</option>
												@endforeach
											</select>
										</div>
										<input type="text" class="form-control" name="state2" id="state2" value="{{ $memberDetail->state }}" />
										<div class="form-error" id="stateFormError"></div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>City <span class="pruple">*</span></label>
										<div class="custom-select" id="city">
											<div class="replacement">@if($memberDetail->city == null) Select City @else {{$memberDetail->cityname}} @endif</div>
											<select class="custom-select" name="city" onChange="custom_select(this)">
												<option value="" selected disabled>Select City</option>
												@foreach($cities as $city)
													<option value="{{ $city->id }}" @if($city->id == $memberDetail->city) selected @endif>{{ $city->name }}</option>
												@endforeach
											</select>
										</div>
										<input type="text" class="form-control" name="city2" id="city2" value="{{ $memberDetail->city }}" />
										<div class="form-error" id="cityFormError"></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>ZIP Code <span class="pruple">*</span></label>
										<div class="custom-select" id="postcode">
											<div class="replacement">@if($memberDetail->postcode == null) Select Post Code @else {{$memberDetail->postcode . ' - '. $memberDetail->postname}} @endif</div>
											<select class="custom-select" name="postcode" onChange="custom_select(this)">
												<option value="" selected disabled>Select Post Code</option>
												@foreach($postalcodes as $code)
													<option value="{{ $code->postal_code }}" @if($code->postal_code == $memberDetail->postcode) selected @endif>{{ $code->postal_code.' - '.$code->postal_name }}</option>
												@endforeach
											</select>
										</div>
										<input type="text" class="form-control" name="postcode2" id="postcode2" value="{{$memberDetail->postcode}}" />
										<div class="form-error" id="postcodeFormError"></div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Telephone Number <span class="purple">*</span></label>
										<div class="clearfix">
											<div class="pull-left">
												<input type="text" class="form-control" name="telephoneNumber" value="{{$memberDetail->telphonenumber}}" />
												<div class="form-error" id="telephoneNumberFormError"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Mobile Number <span class="purple">*</span></label>
										<div class="clearfix">
											<div class="pull-left">
												<input type="text" class="form-control" name="mobileNumber" value="{{$memberDetail->mobilenumber}}" />
												<div class="form-error" id="mobileNumberFormError"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="option-check checkout">
								<input class="labeled-checkbox check-title" name="same_address" type="checkbox" id="labeled-bca">
								<label for="labeled-bca">
									<span class="labeled-checkbox-unchecked"></span>
									<span class="labeled-checkbox-checked"></span>
									<span class="text-check">SAME AS SHIPPING ADDRESS</span>
								</label>
							</div>
							<div class="same_address">
								<div class="title mb30">SHIPPING ADDRESS</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>First Name <span class="pruple">*</span></label>
											<input type="text" class="form-control" name="bfname" value="{{$memberDetail->firstname}}" />
											<div class="form-error" id="bfnameFormError"></div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Last Name <span class="pruple">*</span></label>
											<input type="text" class="form-control" name="blname" value="{{$memberDetail->lastname}}" />
											<div class="form-error" id="blnameFormError"></div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Email Address <span class="pruple">*</span></label>
									<input type="text" class="form-control" name="bemail" value="{{$memberDetail->emailaddress}}" />
									<div class="form-error" id="bemailFormError"></div>
								</div>
								<div class="form-group">
									<label>Address <span class="pruple">*</span></label>
									<input type="text" class="form-control" name="baddress" value="{{$memberDetail->address}}" />
									<div class="form-error" id="baddressFormError"></div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Country <span class="pruple">*</span></label>
											<div class="custom-select">
												<div class="replacement">@if($memberDetail->country == null) Select Country @else {{$memberDetail->countryname}} @endif</div>
												<select class="custom-select" name="bcountry" onChange="custom_select(this)">
													<option value="" selected disabled>Select Country</option>
													@foreach($countries as $country)
														<option value="{{ $country->id }}" @if($country->id == $memberDetail->country) selected @endif>{{ $country->name }}</option>
													@endforeach
												</select>
											</div>
											<div class="form-error" id="bcountryFormError"></div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>State <span class="pruple">*</span></label>
											<div class="custom-select" id="bstate">
												<div class="replacement">@if($memberDetail->state == null) Select State @else {{$memberDetail->statename}} @endif</div>
												<select class="custom-select" name="bstate" onChange="custom_select(this)">
													<option value="" selected disabled>Select State</option>
													@foreach($states as $state)
														<option value="{{ $state->id }}" @if($state->id == $memberDetail->state) selected @endif>{{ $state->name }}</option>
													@endforeach
												</select>
											</div>
											<input type="text" class="form-control" name="bstate2" id="bstate2" value="{{ $memberDetail->state }}" />
											<div class="form-error" id="bstateFormError"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>City <span class="pruple">*</span></label>
											<div class="custom-select" id="bcity">
												<div class="replacement">@if($memberDetail->city == null) Select City @else {{$memberDetail->cityname}} @endif</div>
												<select class="custom-select" name="bcity" onChange="custom_select(this)">
													<option value="" selected disabled>Select City</option>
													@foreach($cities as $city)
														<option value="{{ $city->id }}" @if($city->id == $memberDetail->city) selected @endif>{{ $city->name }}</option>
													@endforeach
												</select>
											</div>
											<input type="text" class="form-control" name="bcity2" id="bcity2" value="{{ $memberDetail->city }}" />
											<div class="form-error" id="bcityFormError"></div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>ZIP Code <span class="pruple">*</span></label>
											<div class="custom-select" id="bpostcode">
												<div class="replacement">@if($memberDetail->postcode == null) Select Post Code @else {{$memberDetail->postcode . ' - '. $memberDetail->postname}} @endif</div>
												<select class="custom-select" name="bpostcode" onChange="custom_select(this)">
													<option value="" selected disabled>Select Post Code</option>
													@foreach($postalcodes as $code)
														<option value="{{ $code->postal_code }}" @if($code->postal_code == $memberDetail->postcode) selected @endif>{{ $code->postal_code.' - '.$code->postal_name }}</option>
													@endforeach
												</select>
											</div>
											<input type="text" class="form-control" name="bpostcode2" id="bpostcode2" value="{{$memberDetail->postcode}}" />
											<div class="form-error" id="bpostcodeFormError"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Telephone Number <span class="purple">*</span></label>
											<div class="clearfix">
												<div class="pull-left">
													<input type="text" class="form-control" name="btelephoneNumber" value="{{$memberDetail->telphonenumber}}" />
													<div class="form-error" id="btelephoneNumberFormError"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Mobile Number <span class="purple">*</span></label>
											<div class="clearfix">
												<div class="pull-left">
													<input type="text" class="form-control" name="bmobileNumber" value="{{$memberDetail->mobilenumber}}" />
													<div class="form-error" id="bmobileNumberFormError"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group mt40">
								<div class="title">ORDER NOTE</div>
								<textarea type="message" class="form-control" name="note"></textarea>
							</div>
						</div>
					</div>
					<div class="col-sm-5 col-lg-3 col-lg-offset-2">
						<div class="right-checkout">
							<div class="title mb30">MY SHOPPING BAG</div>
							<div class="cart-list data-cart cart-checkout">
								@foreach($general->cart as $cart)
									<div class="list">
										<div class="w80"><img src="{{url($cart->productImage)}}" class="img-responsive" /></div>
										<div class="desc">
											<div class="t-cart">{{$cart->productName}}</div>
											<div class="p-cart">IDR {{str_replace(",",".",number_format($cart->productPrice))}}</div>
											<div class="text">
												<div class="clearfix">
													<div class="pull-left" style="width:50px;">Color</div>
													<div class="pull-left color-cart">
														<img src="{{url($cart->productColorPath)}}" class="img-responsive" />
													</div>
												</div>
												@if($cart->productLength)
													<div class="clearfix">
														<div class="pull-left" style="width:50px;">Length</div>
														<div class="pull-left">{{$cart->productLength}}</div>
													</div>
												@endif
												<div class="clearfix">
													<div class="pull-left" style="width:50px;">Size</div>
													<div class="pull-left">{{$cart->productSize}}</div>
												</div>
												<div class="clearfix">
													<div class="pull-left" style="width:50px;">Qty</div>
													<div class="pull-left">{{$cart->productQuantity}}</div>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
							<div class="cart-list data-cart cart-checkout cart-total">
								<div class="list">
									<div class="total">
										<div>SUBTOTAL</div>
										<div class="small">({{$general->cartcount}} Piece(s))</div>
									</div>
									<div class="price">IDR @if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->subtotal)) }} @endif</div>
								</div>
								<div class="list">
									<div class="total">
										<div>VOUCHER</div>
									</div>
									<div class="price">IDR @if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->vouchernominal)) }} @endif</div>
								</div>
								<div class="list">
									<div class="total">TAXES</div>
									<div class="price">IDR @if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->tax)) }} @endif</div>
								</div>
							</div>
							<div class="cart-list data-cart cart-checkout sub-total">
								<div class="list">
									<div>ORDER TOTAL</div>
									<div class="price">IDR @if(str_replace(",",".",number_format($general->cartinfo == null))) 0 @else {{ str_replace(",",".",number_format($general->cartinfo->Header->subtotal - $general->cartinfo->Header->vouchernominal + $general->cartinfo->Header->tax)) }} @endif</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="text-center mt40">
					<a><button type="submit" class="btn btn-blue max" id="btnInfo">CONTINUE TO PAYMENT</button></a>
				</div>
			</form>
		</div>
	</div>
@endsection
