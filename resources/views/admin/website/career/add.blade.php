@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#career').addClass ('active');
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
		<div class="title">{{$title}} Career</div>
		<form method="post" action="{{ url('meisjejongetje/pages/career/submitcareer') }}">
			<div class="form-group">
				<label>Title <span class="red">*</span></label>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" required class="form-control" name="careerId" value="{{$detailJob->careerid}}"/>
				<input type="text" required class="form-control" name="careerTitle" value="{{$detailJob->careertitle}}"/>
			</div>
			<textarea id="mceFixed" name="careerContent">{{$detailJob->careercontent}}</textarea>
			<div class="form-group mt10">
				<input type="checkbox" class="check" name="isPublish" value = "1" @if($detailJob->ispublish == 1) checked @endif>
				<span class="publish-check">Publish</span>
			</div>
			<div class="text-center">
				<a href="{{ url('meisjejongetje/pages/career') }}"><button type="button" class="btn btn-pop mr10">Back</button></a>
				<input type="submit" class="btn btn-pop" value="Submit">
			</div>
		</form>
	</div>
@endsection