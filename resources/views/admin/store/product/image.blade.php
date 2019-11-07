@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$(document).ready(function() {	
			$('#store > ul.submenu').addClass ('open');
			$('li#store').addClass ('open');
			$('#productImage').addClass ('active');
			
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
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td width="60">No</td>
						<td width="100">Main Image</td>
						<td width="200">Back Image</td>
						<td width="100">Sub Image</td>
						<td width="100" class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					@foreach($images as $index => $image)
						<tr>
							<td>{{ $index+1 }}</td>
							<td><div class="w200"><img src="{{ url($image->main) }}" class="img-responsive"/></div></td>
							<td><div class="w200"><img src="{{ url($image->back) }}" class="img-responsive"/></div></td>
							<td>
								@foreach($image->sub as $sub)
									<div class="w200 image-left"><img src="{{ url($sub->subimage) }}" class="img-responsive"/></div>
								@endforeach
							</td>
							<td class="text-center">
								<a class="fancybox deleteClick" href="#delete" data-value="{{$image->imageid}}"><div class="img-delete"></div></a>
							</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
		<div class="border-line"></div>
		<div class="title">Adding New Images</div>
		<form method="post" action="{{url('meisjejongetje/commerce/product/submitimage')}}" enctype="multipart/form-data">
			<div class="clearfix">
				<div class="display-inline mr20">
					<div class="form-group">
						<label>Main Image <span class="red">*</span></label>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="file" name="uploadMainImage">
						<div class="mt5">Tipe File : jpg, jpeg, gif, png</div>
						<div>Pic Resolution : 1080 × 1455 pixels</div>
						<div>Maximum File Size : 1MB</div>
					</div>
				</div>
				<div class="display-inline mr20">
					<div class="form-group">
						<label>Back Image <span class="red">*</span></label>
						<input type="file" name="uploadBackImage">
						<div class="mt5">Tipe File : jpg, jpeg, gif, png</div>
						<div>Pic Resolution : 1080 × 1455 pixels</div>
						<div>Maximum File Size : 1MB</div>
					</div>
				</div>
				<div class="display-inline mr20">
					<div class="form-group">
						<label>Sub Images <span class="red">*</span></label>
						<input type="file" name="uploadSubImage[]" multiple>
						<div class="mt5">Tipe File : jpg, jpeg, gif, png</div>
						<div>Pic Resolution : 1080 × 1455 pixels</div>
						<div>Maximum File Size : 1MB</div>
					</div>
				</div>
				<div>
					<input type="submit" class="btn btn-pop" value="Submit">
				</div>
			</div>
		</form>
	</div>
	
	<!-- Delete -->
	<div id="delete" class="width-pop">
		<div class="pad-pop">
			<div class="title-pop">DELETE</div>
			<div class="img-pop">
				<div class="pop-delete"></div>
			</div>
			<div class="text-center">
				<form action="{{ url('meisjejongetje/commerce/product/deleteimage') }}" method="post">
					<div class="t-delete">Warning : Once its deleted, its category data will be deleted forever</div>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="deleteId" id="deleteId"/>
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