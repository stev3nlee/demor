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
				url: "{{ url('forgot/submit/newpassword') }}",
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
						location.href = "{{url('login')}}";
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
						<div class="title text-center">NEW PASSWORD</div>
						<div class="bdr-title"></div>
					</div>
					<form id="submitForgot" method="post" action="{{url('forgot/submit/newpassword')}}">
						<div class="form-group">
							<label>New Password <span class="purple">*</span></label>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="id" value="{{$id}}"/>
							<input type="hidden" name="token" value="{{$token}}" />
							<input type="password" class="form-control" name="newPassword"/>
							<div class="form-error" id="newPasswordFormError"></div>
						</div>
						<div class="form-group">
							<label>Confirm Password <span class="purple">*</span></label>
							<input type="password" class="form-control" name="confirmPassword"/>
							<div class="form-error" id="confirmPasswordFormError"></div>
						</div>
						<div class="text-center mb20">
							<button type="submit" class="btn btn120">SUBMIT</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection