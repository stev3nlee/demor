@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('li#change-password').addClass ('active');
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
		<div class="clearfix">
			<div class="pull-left">
				<div class="title">Change Password</div>
			</div>							
		</div>			
		<form method="post" action="{{ url('meisjejongetje/settings/changepassword/submitchangepassword') }}">
			<div class="form-group">
				<label>Old Password<span class="red">*</span></label>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="password" class="form-control width500" name="oldPassword" />
			</div>
			<div class="form-group">
				<label>New Password<span class="red">*</span></label>
				<input type="password" class="form-control width500" pattern=".{6,}" title="6 characters minimum" name="newPassword" />
			</div>
			<div class="form-group">
				<label>Confirm New Password<span class="red">*</span></label>
				<input type="password" class="form-control width500" pattern=".{6,}" title="6 characters minimum" name="confirmPassword" />
			</div>
			<div class="clearfix">
				<div class="pull-left mr10">
					<input type="submit" name="" class="btn btn-pop" value="Change" />
				</div>						
			</div>
		</form>
	</div>
@endsection