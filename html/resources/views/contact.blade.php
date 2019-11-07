@extends('layouts.master')

@section('title', 'Page Title')

@section('content')
	<script>
	$(function() {
		$('#submitContact').submit(function(e){
			e.preventDefault();
			$('input, textarea').removeClass('error');
			$('.form-error').html('');

			$.ajax({
				type: "post",
				url: "{{ url('pages/contact/addcontact') }}",
				data: $("#submitContact").serialize(),
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
					else{
						$("input, textarea").val("");
						$("[name=_token]").val('{{ csrf_token() }}');
						$.fancybox.open({
							href: '#success',
						});
					}
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});
	});
	</script>

	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

	<div id="content">
		<div class="container">
			<div class="map pos-rel clearfix">
				<a href="{{ $contact->maps }}" target="_blank">
					<iframe src="{{ $contact->maps }}" width="100%" height="410" frameborder="0" style="border:0" allowfullscreen></iframe>
					<div class="map-overlay"></div>
				</a>
			</div>
			<div class="row">
				<div class="col-sm-6 resp30">
					<div class="title30">
						<div class="title">CONTACT US</div>
						<div class="bdr-title no-center"></div>
					</div>
					<div class="contact20">
						<div class="inline-contact mr20">
							<img src="{{ url('/assets/images/icons/contact01.svg') }}" class="img-responsive"/>
						</div>
						<div class="inline-contact">
							<div class="h30">
								<div class="tbl">
									<div class="cell">
										<div class="t-contact">{{ $contact->email }}</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="contact20">
						<div class="inline-contact mr20">
							<img src="{{ url('/assets/images/icons/contact02.svg') }}" class="img-responsive"/>
						</div>
						<div class="inline-contact">
							<div class="h30">
								<div class="tbl">
									<div class="cell">
										<div class="t-contact">{{ $contact->phonenumber }}</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="contact20">
						<div class="inline-contact mr20">
							<img src="{{ url('/assets/images/icons/contact04.svg') }}" class="img-responsive"/>
						</div>
						<div class="inline-contact">
							<div class="h30">
								<div class="tbl">
									<div class="cell">
										<div class="t-contact">{{ $contact->operation }}</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div>
						<div class="inline-contact mr20">
							<img src="{{ url('/assets/images/icons/contact03.svg') }}" class="img-responsive"/>
						</div>
						<div class="inline-contact">
							<div class="t-contact">{!! $contact->address !!}</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="title30">
						<div class="title">INQUIRY FORM</div>
						<div class="bdr-title no-center"></div>
					</div>
					<form id="submitContact" method="post">
						<div class="form-group">
							<label>Name <span class="purple">*</span></label>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="text" class="form-control" name="name" />
							<div class="form-error" id="nameFormError"></div>
						</div>
						<div class="form-group">
							<label>Email <span class="purple">*</span></label>
							<input type="text" class="form-control" name="email" />
							<div class="form-error" id="emailFormError"></div>
						</div>
						<div class="form-group">
							<label>Subject <span class="purple">*</span></label>
							<div class="custom-select">
								<div class="replacement">General</div>
								<select class="custom-select" name="subject" onChange="custom_select(this)">
									<option value="General" selected>General</option>
									<option value="Exchange Product">Exchange Product</option>
									<option value="Request Product">Request Product</option>
									<option value="Others">Others</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label>Messages <span class="purple">*</span></label>
							<textarea type="message" class="form-control" name="messages" /></textarea>
							<div class="form-error" id="messagesFormError"></div>
						</div>
						<div class="form-group">
							<div class="g-recaptcha" data-sitekey="6LeuMBUUAAAAAGpNaSv2FgJPCLOMjkjal4AfjiSk"></div>
							<div class="form-error" id="captchaFormError"></div>
						</div>
						<div>
							<button type="submit" class="btn btn120">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection
