@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#submitForgot').submit(function(e){
			e.preventDefault();
			$('input').removeClass('error');
			$('.form-error').html('');
			
			$.ajax({
				type: "post",
				url: "{{ url('forgot/submit') }}",
				data: $("#submitForgot").serialize(),
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
						$.fancybox.open({
							href: '#success',
						});
						location.href = "{{url('forgot')}}";
					}
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});
	});
	</script>
	
	<div id="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
					<div class="title30">
						<div class="title text-center">FORGOT PASSWORD</div>
						<div class="bdr-title"></div>
					</div>
					<div class="text-login">Enter your email address to get reset <br/>password instructions sent to your inbox.</div>
					<form method="post" id="submitForgot" action="{{url('forgot/submit')}}">
						<div class="form-group">
							<label>Email Address <span class="purple">*</span></label>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="text" class="form-control" name="email" />
							<div class="form-error" id="emailFormError"></div>
						</div>
						<div class="text-center mb20">
							<button type="submit" class="btn btn120">SUBMIT</button>
						</div>
					</form>
						<div class="text-center">
							<a href="{{ url('login') }}" class="link-small">Back to Sign In</a>
						</div>
				</div>
			</div>
		</div>
	</div>
@endsection