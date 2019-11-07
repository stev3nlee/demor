@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		if("{{$title}}" == "Shop")
			$('.nav_shop').addClass('active');
		else if("{{$title}}" == "NEW ARRIVALS")
			$('.nav_new').addClass('active');
		else
			$('.nav_sale').addClass('active');

		$(".light-pagination").pagination({cssStyle: "light-theme", items: {{(count($products) == 0 ? 1 : ceil($products[0]->count))}},hrefTextPrefix:"{{url($linkPages).'/'}}", currentPage:{{$page}}});
	});
	</script>

	<div id="content">
		<div class="container">
			<div class="title30">
				<div class="title">{{$title}}</div>
				<div class="bdr-title no-center"></div>
			</div>
			<div class="clearfix mb40">
				<div class="pull-left">
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
				@if(count($products) != 0)
				<div class="pull-right hidden-xs">
					<div class="pagination-holder clearfix">
						<div class="light-pagination pagination"></div>
					</div>
				</div>
				@endif
			</div>
			@if($detail != null && count($products) == 0)
				<div class="min400 center">
					<div class="tbl">
						<div class="cell">
							<div class="text-search"><span class="purple bold">"{{ strtoupper($detail) }}"</span> - Total Search : 0</div>
						</div>
					</div>
				</div>
			@elseif(count($products) == 0)
				<div class="min400 center">
					<div class="tbl">
						<div class="cell">
							<div class="text-search">No new items at the moment!</div>
						</div>
					</div>
				</div>
			@endif
			<div class="row mb40">
				@foreach($products as $product)
				<div class="col-xs-6 col-sm-4 col-md-3 item-four">
					<div class="item-list">
						<a href="{{ url('product/detail/'.$product->productid) }}">
							<div class="image">
								<img src="{{ url($product->subimage) }}" class="img-responsive"/>
								<img src="{{ url($product->mainimage) }}" class="img-responsive img-hover"/>
								@if($product->discount != 0)
									<div class="ribbon sale">
										<div class="h50">
											<div class="tbl">
												<div class="cell">SALE</div>
											</div>
										</div>
									</div>
								@endif
							</div>
							<div class="desc">
								<div class="title-prod">{{$product->productname}}</div>
								<div class="price-prod">{{--
									Currency
									IDR
									@if($product->discount != 0)
									<span class="bsale">{{str_replace(",",".",number_format($product->price))}}</span>
									@endif
									<span class="sale">{{str_replace(",",".",number_format($product->price - $product->price * $product->discount / 100))}}</span>
									--}}
									<span class="selected-currency">IDR</span>
									@if($product->discount != 0)
									<span class="default-disc-price-hidden hide">{{ $product->price }}</span>
									<span class="bsale selected-disc-currency-value">{{ $product->price }}</span>
									@endif
									<span class="default-price-hidden hide">{{ $product->price - $product->price * $product->discount / 100 }}</span>
									<span class="sale selected-currency-value">{{ $product->price - $product->price * $product->discount / 100 }}</span>
								</div>
								<ul class="list-color">
									@foreach($product->color as $color)
										<li><img src="{{ url($color->colorpath) }}" class="img-responsive"/></li>
									@endforeach
								</ul>
							</div>
						</a>
					</div>
				</div>
				@endforeach
			</div>
			@if(count($products) != 0)
			<div class="pagination-holder clearfix">
				<div class="light-pagination pagination"></div>
			</div>
			@endif
		</div>
	</div>

@endsection
