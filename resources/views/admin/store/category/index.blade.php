@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$(document).ready(function() {	
			$('#store > ul.submenu').addClass ('open');
			$('li#store').addClass ('open');
			$('#category').addClass ('active');
		});
		
		$( ".deleteClick" ).click(function() {
			$("[name=deleteId]").val($(this).attr('data-value'));
		});
		$( ".editClick" ).click(function() {
			$("[name=editCategoryId]").val($(this).attr('data-value'));
			$("[name=editCategoryName]").val($(this).attr('data-name'));
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
				<div class="title">Category</div>
			</div>
			<div class="pull-right">
				<a class="click-box2"><button type="button" class="btn btn-auto">Add</button></a>
			</div>						
		</div>	
		
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td width="50">No</td>
						<td>Category Name</td>
						<td width="200">
							<div class="text-center">Action</div>
						</td>
					</tr>
				</thead>
				<tbody>
					@foreach($categories as $index => $category)
					<tr>
						<td>{{ $index+1 }}</td>
						<td>{{ $category->categoryname }}</td>
						<td class="text-center">
							<a class="click-box">
								<div class="img-edit editClick" data-value="{{$category->categoryid}}" data-name="{{$category->categoryname}}"></div>
							</a>									
							<a class="fancybox deleteClick" href="#delete" data-value="{{$category->categoryid}}"><div class="img-delete"></div></a>
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
	</div>

	<!-- ADD -->
	<div class="open-box2">
		<div class="in-box">
			<div class="close-box"></div>
			<div class="mt30">
				<form method="post" action="{{ url('meisjejongetje/commerce/productcategory/addCategory') }}">
					<div class="form-group">
						<label>Category Name <span class="red">*</span></label>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="text" class="form-control" name="categoryName">
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn150">Add</button>
					</div>
				</form>
			</div>
		</div>		
	</div>
		
	<!-- EDIT --> 
	<div class="open-box">
		<div class="in-box">
			<div class="close-box"></div>
			<div class="mt30">
				<form method="post" action="{{ url('meisjejongetje/commerce/productcategory/editCategory') }}">
					<div class="form-group">
						<label>Category Name <span class="red">*</span></label>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" class="form-control" name="editCategoryId">
						<input type="text" class="form-control" name="editCategoryName">
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn150">Edit</button>
					</div>
				</form>
			</div>		
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
				<form action="{{ url('meisjejongetje/commerce/productcategory/deleteCategory') }}" method="post">
					<div class="t-delete">Warning : Once its deleted, its category data will be deleted forever</div>
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