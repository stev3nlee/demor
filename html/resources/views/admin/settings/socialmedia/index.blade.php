@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('li#social-media').addClass ('active');
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
				<div class="title">Social Media</div>
			</div>					
		</div>
		<form method="post" action="{{ url('meisjejongetje/pages/footer/submitfooter') }}">
			<div class="form-group">
				<label>Facebook <span class="red">*</span></label>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="type" value="1">
				<input type="text" class="form-control" name="facebook" value="{{$detailFooter->socialfacebook}}" required />
			</div>
			<div class="form-group">
				<label>Instagram <span class="red">*</span></label>
				<input type="text" class="form-control" name="instagram" value="{{$detailFooter->socialinstagram}}" required />
			</div>
			<div class="form-group">
				<label>Pinterest <span class="red">*</span></label>
				<input type="text" class="form-control" name="pinterest" value="{{$detailFooter->socialpinterest}}" required />
			</div>
			<div>
				<button type="submit" class="btn btn-pop">Save</button>						
			</div>
		</form>
	</div>
@endsection