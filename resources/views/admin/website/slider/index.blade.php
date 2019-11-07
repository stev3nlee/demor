@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#slider').addClass ('active');

		$( ".deleteClick" ).click(function() {
			$("[name=deleteId]").val($(this).attr('data-value'));
		});
		$( ".editClick" ).click(function() {
			//show_loader($('#temp'));
			$("[name=editSliderId]").val($(this).attr('data-value'));
			//2019-01-07 penambahan sort by
			$("[name=editSortBy]").val($(this).attr('data-sort-by'));
			$("[name=editPublish]").prop('checked', $(this).attr('data-check') == 1);
			$pathImage = $(this).attr('data-name');
			$path = '{{ url( $path ) }}'+'/'+$pathImage;
			$("#editPath").attr("src", $path );
		});


		/* function show_loader(div)
		{
			var clone = $('#loader').clone();
			clone.appendTo(div);
			clone.show();
		} */
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
				<div class="title">Slider</div>
			</div>
			<div class="pull-right">
				<a class="click-box2"><button type="button" class="btn btn-auto">Add</button></a>
			</div>
		</div>
		<div class="adminTable">
			<table id="table_id">
				<thead>
					<tr>
						<td width="200">Thumbnail</td>
						<td width="150">Image Type</td>
						<td width="150">Date</td>
						<td width="50">Sort By</td>
						<td width="100" class="text-center">Publish</td>
						<td width="100" class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					@foreach($sliders as $slider)
					 <tr>
						<td class="fix-slider"><img src="{{ url($slider->sliderpath) }}" class="img-responsive"></td>
						<td>{{ $slider->imagetype }}</td>
						<td>{{ $slider->uploaddate }}</td>
						<td>{{ $slider->sortby }}</td>
						<td>
							<div class="img-auto">
								<div class="@if($slider->ispublish == 1) icon-correct @else icon-incorrect @endif"></div>
							</div>
						</td>
						<td class="text-center">
							<a class="click-box">
								<div class="img-edit editClick" data-value="{{$slider->sliderid}}" data-sort-by="{{ $slider->sortby }}" data-name="{{$slider->sliderpath}}" data-check="{{$slider->ispublish}}"></div>
							</a>
							<a class="fancybox deleteClick" href="#deleteGallery" data-value="{{$slider->sliderid}}">
								<div class="img-delete"></div>
							</a>
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
				<form method="post" action="{{ url('meisjejongetje/pages/slider/add') }}" enctype="multipart/form-data">
					<div class="form-group">
						<div id="temp"></div>
						<label>Thumbnail :</label>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="file" name="uploadSlider">
						<div class="mt5">Tipe File : jpg, jpeg, gif, png</div>
						<div>Pic Resolution : 1440 x 650 pixels</div>
						<div>Maximum File Size : 1MB</div>
					</div>
					<div class="form-group">
						<input type="checkbox" class="check" name="isPublish" value="true">
						<span class="publish-check">Publish</span>
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
				<form method="post" action="{{ url('meisjejongetje/pages/slider/edit') }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="editSliderId" id="editSliderId">
					<div class="form-group">
						<img id="editPath" />
					</div>
					<div class="form-group">
						<label>Sort By</label>
						<input type="text" name="editSortBy" class="form-control" value="0"/>
					</div>
					<div class="form-group">
						<input type="checkbox" class="check" name="editPublish" value="true" />
						<span class="publish-check">Publish</span>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn150">Edit</button>
					</div>
				</form>
			</div>
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
				<form action="{{ url('meisjejongetje/pages/slider/delete') }}" method="post">
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
