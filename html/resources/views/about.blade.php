@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<div id="content">
		<div class="container">
			@if($page->showimage == 1)
			<div class="home-banner">
				<img src="{{url($page->pagesimage)}}" class="img-responsive"/>
			</div>
			@endif
			@if($page->showvideo == 1)
			<div class="home-banner">
				<iframe width="560" height="315" src="{{url($page->pagesvideo)}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
			</div>
			@endif
			<div class="text-center title30">
				<div class="title">ABOUT DE'MOR</div>
				<div class="bdr-title"></div>
			</div>
			<div class="text-justify ori-font">
				{!! $page->pagestext !!}
			</div>
		</div>
	</div>
@endsection
