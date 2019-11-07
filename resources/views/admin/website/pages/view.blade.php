@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')
	<script>
	$(function() {
		$('#pages').addClass ('active');
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
		<div class="title">View Content: {{ $page[0]->pagesname }}</div>
		<div class="clearfix"></div>
		@if( $page[0]->pagesid == 1 )
		<div class="form-group">
			<img class="img-responsive" src="{{ url( $page[0]->pagesimage ) }}"/>
		</div>
		<p> <iframe width="100%" height="400" src="https://www.youtube.com/embed/0dH3fzC8Xhw" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe> </p>
		@endif
		<div class="form-group ori-font">
			<div>{!! $page[0]->pagestext !!}</div>
		</div>
		<div class="text-center">
			<a href="{{ url('/meisjejongetje/pages') }}"><button type="button" class="btn btn-pop">Back</button></a>
		</div>
	</div>

@endsection