@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$(document).ready(function() {	
			$('#store > ul.submenu').addClass ('open');
			$('li#store').addClass ('open');
			$('#productColour').addClass ('active');
			
			//$( ".deleteClick" ).click(function() {
			//	$("[name=deleteId]").val($(this).attr('data-value'));
			//});
			$( "#table_id" ).on('click','.deleteClick',function() {
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
		<div class="title">Product Colour</div>							
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td width="10">No</td>
						<td width="400">Main Image</td>
						<td width="100" class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					@foreach($colors as $index => $color)
					<tr>
						<td>{{$index+1}}</td>
						<td><img src="{{ url($color->colorpath) }}"></td>
						<td class="text-center">
							<a class="fancybox deleteClick" href="#deleteUser" data-value="{{$color->colorid}}">
								<div class="img-delete"></div>
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
		<div class="border-line"></div>
		<form method="post" action="{{url('meisjejongetje/commerce/product/submitcolor')}}" enctype="multipart/form-data">
			<div class="row clearfix">
				<div class="wdth50">
					<div class="form-group">
						<label>Color <span class="red">*</span></label>
					</div>
					<div class="display-inline mb10">
						<div class="form-group">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="file" name="addColor" />
							<div class="mt5 ">Tipe File : jpg, jpeg, gif, png</div>
							<div>Pic Resolution : 150 x 150 pixels</div>
						</div>						
					</div>
					<div>
						<input type="submit" class="btn btn-pop" value="Submit">
					</div>
				</div>
			</div>
		</form>
	</div>
	
	<div id="deleteUser" class="width-pop">
		<div class="pad-pop">
			<div class="title-pop">DELETE</div>
			<div class="img-pop">
				<div class="pop-delete"></div>
			</div>
			 <div class="text-center">
				<form action="{{ url('meisjejongetje/commerce/product/deletecolor') }}" method="post">
					<!--<div class="t-delete">Warning : Once its deleted, its category data will be deleted forever</div>-->
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="deleteId" id="deleteID"/>
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