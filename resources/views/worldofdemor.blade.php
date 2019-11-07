@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('.nav_world').addClass('active');
	});
	</script>

	<div id="content">
		<div class="container">
			<div class="title30">
				<div class="title">WORLD OF DE'MOR</div>
				<div class="bdr-title no-center"></div>
			</div>
			<div class="mb40">
				<div class="breadcrumb">
					@foreach($breadCrumb as $index => $b)
						@if($b->path == '')
							<span class="active">{{$b->name}}</span>
						@else
							<a href="{{ url($b->path) }}">{{$b->name}}</a>
						@endif
						@if($index != count($breadCrumb) - 1)
							<span class="m10"> / </span>
						@endif
					@endforeach
				</div>
			</div>
			@if(count($demors) == 0)
			<div class="min400 center">
				<div class="tbl">
					<div class="cell">
						<div class="text-search">No new blogs at the moment!</div>
					</div>
				</div>
			</div>
			@endif
			<?php $x=1; ?>
			@foreach($demors as $index => $demor)
				@if($index %2 == 0)
				<div class="row demor40">
				@endif
					@if($demor->method == 'select-image')
						<div class="col-sm-6 item-demor">
							<a href="{{url($demor->urlpath)}}" target="_blank">
								<div><img src="{{url($demor->filepath)}}" class="img-responsive"/></div>
								<div class="text-demor">{!!$demor->description!!}</div>
							</a>
						</div>
					@elseif($demor->method == 'select-video')
						<div class="col-sm-6 item-demor">
							@if(!empty($demor->filepath))
							<video class="responsive-video" controls>
								<source src="{{ url($demor->filepath) }}" type="video/mp4">
							</video>
							@else
								<iframe width="100%" height="300" src="{{ $demor->youtubepath }}?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
							@endif
							<div class="text-demor">{!!$demor->description!!}</div>
						</div>
					@elseif($demor->method == 'select-slider')
						<div class="col-sm-6 item-demor">
							<div class="pos-rel">
								<div class="owl-demo{{$x}} owl-carousel">
									@foreach($demor->filepath as $path)
									<div class="item">
										<a href="{{ url($path->urlpath) }}" target="_blank">
											<img src="{{ url($path->filepath) }}" class="img-responsive"/>
										</a>
									</div>
									@endforeach
								</div>
								<ul class="owlStatus{{$x}}">
									<li>
										<div class="currentItem"><span class="result"></span></div>
									</li>
									<li>/</li>
									<li>
										<div class="owlItems"><span class="result"></span></div>
									</li>
								</ul>
							</div>
							<div class="text-demor">{!!$demor->description!!}</div>
						</div>
						<?php $x++; ?>
					@endif
				@if($index %2 == 1)
				</div>
				@endif
			@endforeach
		</div>
	</div>

<script>
@for($x=1; $x <=count($demors); $x++)
	var b{{$x}} = $(".owl-demo{{$x}}"), c{{$x}} = $(".owlStatus{{$x}}");
	b{{$x}}.owlCarousel({
		navigation: true,
		afterAction: e{{$x}},
		navigationText: [ "", "" ],
		slideSpeed: 300,
		paginationSpeed: 300,
		singleItem: true,
		autoPlay: true,
		pagination: false,
		paginationNumbers: false
	});
	function d{{$x}}(a, b) {
		c{{$x}}.find(a).find(".result").text(b);
	}
	function e{{$x}}() {
		d{{$x}}(".owlItems", this.owl.owlItems.length);
		d{{$x}}(".currentItem", this.owl.currentItem + 1);
	}
@endfor
</script>

<style>
@for($x=1; $x <=count($demors); $x++)
ul.owlStatus{{$x}} { margin: 0; padding: 0; position: absolute; bottom: 0; right: 0; background: white; padding: 10px 30px !important; }
ul.owlStatus{{$x}} li { display: inline-block; margin-right: 1px; font-size: 12px !important; line-height: 26px !important; }
ul.owlStatus{{$x}} li:last-child { margin-right: 0; }
.owl-demo{{$x}} a { display: block; }
.owl-demo{{$x}} .owl-controls .owl-buttons { position: absolute; bottom: 0; right: 0; z-index: 99; width: 88px; height: 46px; }
.owl-demo{{$x}}.owl-theme .owl-controls .owl-buttons .owl-next { width: 11px; height: 20px; background:url(../../assets/images/icons/next-demor.svg) no-repeat; padding: 0; position: absolute; right: 10px; top: 50%; margin-top: -10px; }
.owl-demo{{$x}}.owl-theme .owl-controls .owl-buttons .owl-next:hover { opacity: 0.7; }
.owl-demo{{$x}}.owl-theme .owl-controls .owl-buttons .owl-prev { width: 11px; height: 20px; background:url(../../assets/images/icons/prev-demor.svg) no-repeat; padding: 0; position: absolute; left: 7px; top: 50%; margin-top: -10px; }
.owl-demo{{$x}}.owl-theme .owl-controls .owl-buttons .owl-prev:hover { opacity: 0.7; }
@endfor
</style>
@endsection
