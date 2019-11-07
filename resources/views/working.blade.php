@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<div id="content">
		<div class="container">
			<div class="text-center title30">
				<div class="title">WORKING WITH DE'MOR</div>
				<div class="bdr-title"></div>
			</div>
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="text-justify ori-font">
						<p>{!! $career->careercontent !!}</p>
					</div>
				</div>
			</div>
			@if(count($detailCareers) == 0)
			<div class="margin60">
				<div class="text-search text-center"><span class="purple bold">"NO VACANCY AT THE MOMENT"</span></div>
			</div>
			<div class="text-faq">
				<div>Please post your resume to our email:</div>
				<div class="purple">{{$career->email}}</div>
			</div>
			@else
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<div id="accordion" class="box-faq">
						@foreach($detailCareers as $detail)
						<div class="txt-faq">{{ $detail->careertitle }}</div>
						<div class="list-faq">
							<div class="text-justify ori-font">
								{!! $detail->careercontent !!}
							</div>
						</div>
						@endforeach
					</div>
					<div class="text-faq">
						<div>To apply, please send your CV to our email:</div>
						<div class="purple">{{$career->email}}</div>
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>

@endsection