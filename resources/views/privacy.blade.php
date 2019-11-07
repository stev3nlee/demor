@extends('layouts.master')

@section('title', 'Page Title')

@section('content')
	
	<div id="content">
		<div class="container">
			<div class="text-center title30">
				<div class="title">PRIVACY POLICY</div>
				<div class="bdr-title"></div>
			</div>
			<div class="text-justify ori-font">
				{!! $page->pagestext !!}
			</div>
		</div>
	</div>

@endsection