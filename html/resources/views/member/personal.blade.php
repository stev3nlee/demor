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
		}
		else
		{
			$('#state').hide();
			$('#city').hide();
			$('#postcode').hide();
		}
		$('.account-personal').addClass('active');
		
		$('#submitPersonal').submit(function(e){
			e.preventDefault();
			$('input').removeClass('error');
			$('.form-error').html('');
			
			$.ajax({
				type: "post",
				url: "{{ url('member/personal/submit') }}",
				data: $("#submitPersonal").serialize(),
				dataType: 'json',
				success: function (data) {
					console.log(data);
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
					else{
						//$("input, textarea").val("");
						$.fancybox.open({
							href: '#success',
						});
						window.location.href="{{url('member')}}";
					}
				},
				error: function (data) {
					console.log('Error:', data);
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
	});
	</script>
	
	<div id="content" class="box-date">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-lg-3 resp40">
					<div class="title30">
						<div class="title">MEMBER AREA</div>
						<div class="bdr-title no-center"></div>
					</div>
					<div class="visible-xs mb25">
						<div class="custom-select">
							<div class="replacement">Personal</div>
							<select class="custom-select" onChange="change_mymenu(this.value)">
								<option value="{{ url('/member') }}" selected>Personal</option>
								<option value="{{ url('/member/order') }}">Order History</option>
								<option value="{{ url('/member/confirmpayment') }}">Confirm Payment</option>
								<option value="{{ url('/member/newsletter') }}">Newsletter</option>
								<option value="{{ url('/member/changepassword') }}">Change Password</option>
								<option value="{{ url('logout') }}">Log Out</option>
							</select>
						</div>
					</div>
					<ul class="list-account hidden-xs">
						<li>
							<a class="account-personal" href="{{ url('/member') }}">
								<div class="account01">Personal</div>
							</a>
						</li>
						<li>
							<a class="account-order" href="{{ url('/member/order') }}">
								<div class="account02">Order History</div>
							</a>
						</li>
						<li>
							<a class="account-confirm-payment" href="{{ url('/member/confirmpayment') }}">
								<div class="account06">Confirm Payment</div>
							</a>
						</li>
						<li>
							<a class="account-newsletter" href="{{ url('/member/newsletter') }}">
								<div class="account03">Newsletter</div>
							</a>
						</li>
						<li>
							<a class="account-change-password" href="{{ url('/member/changepassword') }}">
								<div class="account04">Change Password</div>
							</a>
						</li>
					</ul>
					<a class="a-logout hidden-xs" href="{{ url('logout') }}">LOG OUT</a>
				</div>
				<div class="col-sm-8 col-lg-7">
					<form method="post" id="submitPersonal">
						<div class="mb40">
							<div class="account01 bold account40">Personal</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>First Name <span class="purple">*</span></label>
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" class="form-control" name="id" value="{{$member->userid}}" />
										<input type="text" class="form-control" name="firstName" value="{{$member->firstname}}" />
										<div class="form-error" id="firstNameFormError"></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Last Name <span class="purple">*</span></label>
										<input type="text" class="form-control" name="lastName" value="{{$member->lastname}}"/>
										<div class="form-error" id="lastNameFormError"></div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Email Address <span class="purple">*</span></label>
								<input type="text" class="form-control" name="email" value="{{$member->emailaddress}}" disabled/>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Date of birth <span class="purple">*</span></label>
										<div class="clearfix">
											<div class="custom-select w-date pull-left">														
												<div class="replacement">{{ date_format(date_create($member->dateofbirth), 'd') }}</div>
												<select class="custom-select" name="date" onChange="custom_select(this)">
													@for($i = 1; $i <= 31; $i++)
													<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>														
											</div>
											<div class="custom-select w-date pull-left">														
												<div class="replacement">{{ date_format(date_create($member->dateofbirth), 'M') }}</div>
												<select class="custom-select" name="month" onChange="custom_select(this)">
													<option value="1">Jan</option>
													<option value="2">Feb</option>
													<option value="3">Mar</option>
													<option value="4">Apr</option>
													<option value="5">May</option>
													<option value="6">Jun</option>
													<option value="7">Jul</option>
													<option value="8">Aug</option>
													<option value="9">Sep</option>
													<option value="10">Oct</option>
													<option value="11">Nov</option>
													<option value="12">Dec</option>
												</select>														
											</div>
											<div class="custom-select w-year pull-left">
												<div class="replacement">{{date_format(date_create($member->dateofbirth), 'Y')}}</div>
												<select class="custom-select" name="year" onChange="custom_select(this)">
													@for ($i = date('Y') - 10; $i >= 1950; $i--)
													<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>														
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Gender <span class="purple">*</span></label>
										<div class="custom-select">													
											<div class="replacement">{{$member->gender}}</div>
											<select class="custom-select" name="gender" onChange="custom_select(this)">
												<option value="Male">Male</option>
												<option value="Female">Female</option>
											</select>													
										</div>													
									</div>
								</div>
							</div>
						</div>
						<div>
							<div class="account05 bold mb40">Address</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Country <span class="purple">*</span></label>
										<div class="custom-select">													
											<div class="replacement">@if($member->country == null) Select Country @else {{$member->countryname}} @endif</div>
											<select class="custom-select" name="country" onChange="custom_select(this)">
												<option value="" selected disabled>Select Country</option>
												@foreach($countries as $country)
													<option value="{{ $country->id }}" @if($country->id == $member->country) selected @endif>{{ $country->name }}</option>
												@endforeach
											</select>			
										</div>
										<div class="form-error" id="countryFormError"></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>State <span class="purple">*</span></label>
										<div class="custom-select" id="state">													
											<div class="replacement">@if($member->state == null) Select State @else {{$member->statename}} @endif</div>
											<select class="custom-select" name="state" onChange="custom_select(this)">
												<option value="" disabled>Select State</option>
												@foreach($states as $state)
													<option value="{{ $state->id }}" @if($state->id == $member->state) selected @endif>{{ $state->name }}</option>
												@endforeach
											</select>													
										</div>
										<input type="text" class="form-control" name="state2" id="state2" value="{{ $member->state }}" />
										<div class="form-error" id="stateFormError"></div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>City <span class="purple">*</span></label>
										<div class="custom-select" id="city">													
											<div class="replacement">@if($member->city == null) Select City @else {{$member->cityname}} @endif</div>
											<select class="custom-select" name="city" onChange="custom_select(this)">
												<option value="" disabled>Select City</option>
												@foreach($cities as $city)
													<option value="{{ $city->id }}" @if($city->id == $member->city) selected @endif>{{ $city->name }}</option>
												@endforeach
											</select>													
										</div>
										<input type="text" class="form-control" name="city2" id="city2" value="{{ $member->city }}" />
										<div class="form-error" id="cityFormError"></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>ZIP Code <span class="purple">*</span></label>
										<div class="custom-select" id="postcode">													
											<div class="replacement">@if($member->postcode == null) Select Post Code @else {{$member->postcode . ' - '. $member->postname}} @endif</div>
											<select class="custom-select" name="postcode" onChange="custom_select(this)">
												<option value="" disabled>Select Post Code</option>
												@foreach($postalcodes as $code)
													<option value="{{ $code->postal_code }}" @if($code->postal_code == $member->postcode) selected @endif>{{ $code->postal_code.' - '.$code->postal_name }}</option>
												@endforeach
											</select>													
										</div>
										<input type="text" class="form-control" name="postcode2" id="postcode2" value="{{ $member->postcode }}" />
										<div class="form-error" id="postcodeFormError"></div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Address <span class="purple">*</span></label>
								<textarea type="message" class="form-control" name="address">{{$member->address}}</textarea>
								<div class="form-error" id="addressFormError"></div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Telephone Number</label>
										<div class="clearfix">
											<div class="w-number pull-left">
												<input type="text" class="form-control" name="telphoneNumber" value="{{$member->telphonenumber}}" />
											</div>
										</div>
										<div class="form-error" id="telphoneNumberFormError"></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Mobile Number <span class="purple">*</span></label>
										<div class="clearfix">
											<div class="w-number pull-left">
												<input type="text" class="form-control" name="mobileNumber" value="{{$member->mobilenumber}}" />
											</div>
										</div>
										<div class="form-error" id="mobileNumberFormError"></div>
									</div>
								</div>
							</div>
						</div>
						<div>
							<button type="submit" class="btn btn120">SAVE CHANGES</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection