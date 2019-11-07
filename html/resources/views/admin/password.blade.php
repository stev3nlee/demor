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
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/css/fonts.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('adminassets/css/web.css')}}">
	
	<!-- JS -->
	<script type="text/javascript" src="{{URL::asset('adminassets/js/jquery-1.11.1.min.js')}}"></script>
	
</head>
<body>
	
	<div class="full-height">
		<div class="tbl">
			<div class="cell">
				<div class="box-login">	
					<div class="box-sign effect8">
						<div class="logo">
							<img src="../adminassets/uploads/logo2.png"/>
						</div>
						<form method="post" action="" name="loginform">
							<div class="form-group">
								<div class="form-error"></div>
								<label>Request a password reset. Enter your username and you'll get a mail with instructions:</label>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="text" class="form-control" required name="admin_password" />
							</div>
							<div class="clearfix">
								<div class="pull-left">
									<input type="submit" name="" class="btn btn-pass" value="Reset my password" />
								</div>
								<div class="pull-right">
									<div class="center-forget">
										<div class="tbl">
											<div class="cell">
												<a href="{{ url('/meisjejongetje/') }}">Back to Login Page</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>