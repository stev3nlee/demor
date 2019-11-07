@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#newsletter').addClass ('active');

		$( ".deleteClick" ).click(function() {
			$("[name=deleteId]").val($(this).attr('data-value'));
		});

		$('input[name="show-product"]').click(function() {
			if ($(this).is(":checked")) $(".show-product").stop(true, true).slideUp(); else $(".show-product").stop(true, true).slideDown();
		});
	});


	</script>

	<style type="text/css">
		.select2 { border-radius: 0; display: block; width: 100%; height: 35px; padding: 2px 10px; font-size: 14px; line-height: 2; background-color: #fff; background-image: none;	border: 1px solid #d0d0d0; position: relative; color: #4c4c4c; }
		input { outline: none; }
		select { outline: none; }
		select:active, select:hover { outline:none; }
		.select2-drop-active { border: none; !important; outline:none; !important; }
		.select2-drop.select2-drop-above.select2-drop-active { border-top: none; !important; }
		.select2-container-active .select2-choice, .select2-container-active .select2-choices { border: none; !important; outline: none !important;	}
		.select2-selection__rendered { border: none; !important; outline: none !important; }
	</style>

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
		<div class="title">Emails</div>
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td>No</td>
						<td>Email Address</td>
						<td class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					@foreach($newsletters as $index => $newsletter)
						 <tr>
							<td width="60">{{$index+1}}</td>
							<td>{{$newsletter->email}}</td>
							<td width="150" class="text-center">
								<a class="fancybox" href="#deleteGallery">
									<div class="img-delete deleteClick" data-value="{{$newsletter->email}}"></div>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
		<div class="border-line"></div>
		<div class="title">Newsletter</div>
			<form method="post" action="{{ url('/meisjejongetje/pages/send/newsletter/') }}"  enctype="multipart/form-data">
				{{csrf_field()}}
				<div class="form-group">
					<label>To <span class="red">*</span></label>
					<select class="custom-select form-control" name="to" onchange="custom_select(this)">
						<option value="1">All Newsletters</option>
						<option value="2">Preview testing to cs@demorboutique.com</option>
						<!--<option value="3">Preview testing to Dilenium</option>-->
					</select>
				</div>
				<div class="form-group">
						<div class="form-group">
							<label>Thumbnail :</label>
							<input type="file" id="btnAddUpload" name="upload_image">
							<div class="mt5">Tipe File : jpg, jpeg, gif, png</div>
							<div>Pic Resolution : 1440 x 650 pixels</div>
							<div>Maximum File Size : 1MB</div>
						</div>
				</div>
				<div class="form-group">
					<label>Campaign Name <span class="red">*</span></label>
					<input type="text" required class="form-control" name="campaign_name" />
				</div>
				<div class="form-group">
					<label>Template <span class="red">*</span></label>
					<textarea id="mceFixed" name="template"></textarea>
				</div>
				<div class="form-group">
					<input type="checkbox" class="check" name="show-product" value="1">
					<span class="">Hide Product </span>
				</div>
				<div class="show-product">
					<div class="title">Products (Max 6 only)</div>
					<div class="clearfix">
						@for($x=1; $x<=6; $x++)
						<div class="row">
							<div class="wdth50">
								<div class="form-group">
									<label>Products {{$x}}</label>
									<select class="form-control select2" name="product[]">
										@foreach($products as $product)
										<option value="{{$product->productid}}">{{$product->productname}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<?php $x++; ?>
							<div class="wdth50">
								<div class="form-group">
									<label>Products {{$x}}</label>
									<select class="form-control select2" name="product[]">
										@foreach($products as $product)
										<option value="{{$product->productid}}">{{$product->productname}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						@endfor
					</div>
				</div>
				<input type="submit" class="btn btn-pop" value="send"/>
			</form>
		</div>
	</div>

	<!-- DELETE -->
	<div id="deleteGallery" class="width-pop">
		<div class="pad-pop">
			<div class="title-pop">DELETE</div>
			<div class="img-pop">
				<div class="pop-delete"></div>
			</div>
			 <div class="text-center">
				<form action="{{ url('meisjejongetje/pages/newsletter/delete') }}" method="post">
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
