@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$(document).ready(function() {	
			$('#store > ul.submenu').addClass ('open');
			$('li#store').addClass ('open');
			$('#product').addClass ('active');
			
			$( ".deleteClick" ).click(function() {
				$("[name=deleteId]").val($(this).attr('data-value'));
			});
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
		<div class="clearfix">
			<div class="pull-left">
				<div class="title">Product</div>
			</div>
			<div class="pull-right">
				<a href="{{ url('meisjejongetje/commerce/product/addproduct') }}"><button type="button" class="btn btn-auto">Add</button></a>
			</div>						
		</div>	
		
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td width="60">No</td>
						<td width="100">Product Code</td>
						<td width="200">Product Name</td>
						<td width="100">Image</td>
						<td width="200">Category</td>
						<td width="150">
							<div class="text-center">Action</div>
						</td>
					</tr>
				</thead>
				<tbody>
					@foreach($products as $index => $product)
						<tr>
							<td>{{ $index+1 }}</td>
							<td>{{ $product->productcode }}</td>
							<td>{{ $product->productname }}</td>
							<td><div class="w100"><img src="{{ url($product->mainimage) }}" class="img-responsive"/></div></td>
							<td>{{ $product->categoryname }}</td>
							<td class="text-center">
								<a href="{{ url('meisjejongetje/commerce/view/'.$product->productid) }}">
									<div class="img-view"></div>
								</a>
								<a href="{{ url('meisjejongetje/commerce/product/editproduct/'.$product->productid) }}">
									<div class="img-edit"></div>
								</a>
								<a class="fancybox deleteClick" href="#delete" data-value="{{$product->productid}}"><div class="img-delete"></div></a>
							</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
	</div>

	<!-- Delete -->
	<div id="delete" class="width-pop">
		<div class="pad-pop">
			<div class="title-pop">DELETE</div>
			<div class="img-pop">
				<div class="pop-delete"></div>
			</div>
			<div class="text-center">
				<form action="{{ url('meisjejongetje/commerce/product/deleteproduct') }}" method="post">
					<!--<div class="t-delete">Warning : Once its deleted, its category data will be deleted forever</div>-->
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" required name="deleteId" id="deleteId"/>
					<div class="inline">
						<button class="btn btn-sure">Yes</button>
					</div>
					<div class="inline">
						<button class="btn btn-cancel no-popup" type="button">No</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection