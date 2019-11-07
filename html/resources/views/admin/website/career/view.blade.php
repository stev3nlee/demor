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
		<div class="title">View Career</div>
		<div class="form-group">
			<label>Title</label>
			<div>{{ $detailJob->careertitle }}</div>
		</div>
		<div class="form-group">
			<label>Content</label>
			{!! $detailJob->careercontent !!}
		</div>
		<div>
			<a href="{{ url('meisjejongetje/pages/career') }}"><button type="button" class="btn btn-pop">Back</button></a>
		</div>
	</div>

@endsection