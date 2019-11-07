<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">-->
	<title>Admin</title>
	
	<!-- Favicon -->
	<link rel="icon" type="image/ico" href="{{URL::asset('adminassets/uploads/favicon.ico')}}">
	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/css/bootstrap.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/css/fonts.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/css/web.css')}}">
	
	<!-- JS -->
	<script type="text/javascript" src="{{URL::asset('adminassets/js/jquery-1.11.1.min.js')}}"></script>
	
</head>
<body>
<script>
$(function() {
	$('.full-height').height($(window).height());
});
</script>

	<div class="full-height">
		<div class="tbl">
			<div class="cell">
				<div class="box-login">	
					<div class="box-sign effect8">
						<div class="logo">
							<img src="adminassets/uploads/logo2.png"/>
						</div>
						@if(Session::has('message'))
						<div class="alert {{Session::get('message')->type}}">
							{{Session::get('message')->content}}
						</div>
						@endif
						<form method="post" action="{{ url('/meisjejongetje/login') }}" name="loginform">
							<div class="form-group">
								<div class="form-error"></div>
								<label>Email</label>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="text" class="form-control" required name="email" />
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="password" class="form-control" required name="password" />
							</div>
							<div class="form-group">
								<input type="checkbox" id="admin_rememberme" name="remember" /><label>Remember Me </label>
							</div>
							<input type="submit" name="login" class="btn btn200" value="Login" />
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>