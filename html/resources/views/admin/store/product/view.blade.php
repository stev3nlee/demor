@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')


<script>
$(function() {
	$(document).ready(function() {	
		$('#store > ul.submenu').addClass ('open');
		$('li#store').addClass ('open');
		$('#product').addClass ('active');
	});
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
		<div class="title">View Product: {{ $product->productname }}</div>
		<div class="row clearfix">
			<div class="wdth50">
				<div class="form-group" style="margin-bottom: 60px;">
					<label>Product Description</label>
					<div>{!! $product->productdescription !!}</div>
				</div>
				<div class="form-group">
					<label>Size Chart</label>
					<div class="clearfix table-size">
						{!! $product->sizechart !!}
					</div>
				</div>
				<div class="form-group">
					<label>Product Size</label>
					<div class="adminTable">
						<table>
							<thead>
							<tr>
								<td>Size</td>
								<td>Color</td>
								<td>Stock</td>
								<td>Price</td>
								<td>Sale</td>
							</tr>
							</thead>
							<tbody>
								@foreach($sizes as $size)
								<tr>
									<td>{{$size->size}}</td>
									<td><img src="{{ url($size->colorpath) }}"/></td>
									<td>{{ $size->stock }}</td>
									<td>IDR {{ str_replace(",",".",number_format($product->price)) }}</td>
									<td>IDR {{ str_replace(",",".",number_format($product->price - ( $product->price * $product->discount / 100 ))) }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div>
			<a href="{{ url('meisjejongetje/commerce/product') }}"><button type="button" class="btn btn-pop mr10">Back</button></a>
		</div>
	</div>

@endsection