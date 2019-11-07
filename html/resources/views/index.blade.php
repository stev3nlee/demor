@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<style>
	#header { border-bottom: 0; }
	.hidden-index { display: none; }
	</style>

	<script>
	$(function() {
		$('.nav_home').addClass('active');
	});
	</script>
	<div id="pop-description" class="width-pop">
		<div class="pad-pop">
			<div class="title-pop">Description</div>
			<div class="word-pop">
			</div>
		</div>
	</div>

	<div class="hdr-container full-container">
		<div id="home-banner" class="owl-carousel">
			@foreach($sliders as $slider)
			<div class="item">
				<img src="{{ url($slider->sliderpath) }}" class="img-responsive"/>
			</div>
			@endforeach
		</div>
	</div>
	<div class="container">
		<div class="a-home">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="row">
						<div class="col-xs-6">
							@if($others->method == 2)
							<div class="index-slider owl-carousel">
								@foreach($populars as $popular)
									<div class="item">
									<a href="{{ url('product/detail/'.$popular->productid) }}"><img src="{{ url($popular->mainimage) }}" class="img-responsive"/></a>
									</div>
								@endforeach
							</div>
							<div class="t-index">{{$others->submenuname}}</div>
							@endif
							@if($others->method == 3)
							<a href="{{ url('product/collection') }}">
							<div class="index-slider owl-carousel">
								@foreach(explode(":",$others->collectionbanner) as $banner)
								<div class="item"><img src="{{ asset($banner) }}" class="img-responsive"/></div>
								@endforeach
							</div>
							<div class="t-index">{{$others->submenuname}}</div>
							</a>
							@endif
						</div>
						<div class="col-xs-6">
							<a href="{{ url('product/arrival') }}">
								<div class="index-slider owl-carousel">
									@foreach($arrivals as $arrival)
										<div class="item">
											<img src="{{ url($arrival->mainimage) }}" class="img-responsive"/>
										</div>
									@endforeach
								</div>
								<div class="t-index">NEW ARRIVALS</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@php
		if(Session::has('popup'))
		{
			if(Session::get('popup.popup_type') != $popup->popup_type){
				Session::put('popup',array("popup_type"=>$popup->popup_type,"is_popped"=>0));
				Session::save();
			}
		}else{
			Session::put('popup',array("popup_type"=>$popup->popup_type,"is_popped"=>0));
			Session::save();
		}
	@endphp
	@if(strtotime(date("Y-m-d"))>=strtotime($popup->start_popup) and strtotime(date("Y-m-d"))<=strtotime($popup->end_popup) and Session::get('popup')['is_popped'] == 0)
	<script>
	$(document).ready(function(){
		$("#onpage").fancybox().trigger("click");
	})
	</script>
	<a id="onpage" class="fancybox" href="#popupindex"></a>
	<div class="overlay" id="popupindex">
		<div class="fancybox-outer" style="">
				<!-- IF ADMIN CHOOSE BANNER, SHOW LINE 23, IF ADMIN CHOOSE TEXT, JUST COMMENT LINE 23 -->
				@if($popup->popup_type == 1)
					<div class="fancybox-inner text-center" style="position:relative; overflow: auto; height: auto;">
						<div style="overflow: auto; padding-top:85px; padding-bottom:95px; padding-left:85px; padding-right:95px;">
							<div class="ori-font">{!! $popup->message !!}</div>
						</div>
					</div>
				@else
				<div class="text-center"><a href="{{ $popup->link_path }}" target="_blank"><img src="{{ url($popup->image_path) }}" height="100%" width="100%"></a></div>
				@endif
		</div>
	</div>

	@php   Session::put('popup',array("popup_type"=>$popup->popup_type,"is_popped"=>1)) @endphp
	@php Session::save() @endphp
	@endif
@endsection
