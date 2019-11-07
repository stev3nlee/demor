@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#blog > ul.submenu').addClass ('open');
		$('li#blog').addClass ('open');
		$('#blog-list').addClass ('active');

		var clrIndex = 0;

		$("select#select-method").change(function(){
			$(this).find("option:selected").each(function(){
				if($(this).attr("value")=="select-image"){
					$(".box-method").not(".select-image").hide();
					$(".hide-add").show();
					$(".select-image").show();
				}
				else if($(this).attr("value")=="select-video"){
					$(".box-method").not(".select-video").hide();
					$(".hide-add").show();
					$(".select-video").show();
				}
				else if($(this).attr("value")=="select-slider"){
					$(".box-method").not(".select-slider").hide();
					$(".hide-add").show();
					$(".select-slider").show();
				}
				else{
					$(".box-method").hide();
					$(".hide-add").hide();
				}
			});
		}).change();

		$('.addSliderUrlClick').click(function(){
			var clone = $('#hiddenClass').clone().removeAttr('id').removeClass('hidden').attr('id', 'clr'+clrIndex);
			clone.find('.deleteUrlSlider').attr('data-value', clrIndex);
			clone.find('input').prop('required', true);

			$('#genUrlSlider').append(clone);
			clrIndex++;

			$('.deleteUrlSlider').unbind().click(function(){
				$('#clr'+$(this).attr('data-value')).remove();
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
		<div class="title">Add List</div>
		<form method="post" enctype="multipart/form-data" action="{{ url('meisjejongetje/pages/blog/addlist/submit') }}">
			<div class="clearfix row">
				<div class="wdth50">
					<div class="form-group">
						<label>Category <span class="red">*</span></label>
						<select class="form-control" id="category" name="categoryId">
							@foreach($demors as $demor)
								<option value="{{$demor->categoryid}}">{{$demor->categoryname}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="wdth50">
					<div class="form-group">
						<label>Blog Name <span class="red">*</span></label>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="text" class="form-control" name="blogName" required/>
					</div>
				</div>
			</div>
			<div class="clearfix row">
				<div class="wdth50">
					<div class="form-group">
						<label>Methods <span class="red">*</span></label>
						<select class="form-control" id="select-method" name="methods">
							<option>Select Method</option>
							<option value="select-image">Image Static</option>
							<option value="select-video">Video</option>
							<option value="select-slider">Slider</option>
						</select>
					</div>
				</div>
			</div>
			<!-- select image -->
			<div class="select-image box-method">
				<div class="row clearfix">
					<div class="wdth50">
						<div class="form-group">
							<label>Upload <span class="red">*</span></label>
							<input type="file" name="imageStatic">
							<div class="mt5" style="font-size:12px;">File Type : jpg, jpeg, gif, png, pic. Resolution : 570 x 370 pixels. Maximum File Size : 1MB</div>
						</div>
					</div>
					<div class="wdth50">
						<div class="form-group">
							<label>Url <span class="red">*</span></label>
							<input type="text" class="form-control" name="urlImageStatic" />
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="wdth50">
						<div class="form-group">
							<label>Subtitle <span class="red">*</span></label>
							<textarea id="mceFixed" name="subtitleImageStatic"></textarea>
						</div>
					</div>
				</div>
			</div>
			<!-- end image -->
			<!-- select video -->
			<div class="select-video box-method">
				<div class="form-group">
					<label>Upload (Optional)</label>
					<input type="file" name="video">
					<div class="mt5">File Type : mp4, avi</div>
					<div>Pic Resolution : 570 x 370 pixels</div>
				</div>
				<div class="form-group">
					<label>YouTube Video (Embed) <span class="red">*</span></label>
					<input type="text" class="form-control" style="width:50%;" name="youtube" value="" />
				</div>
				<div class="row clearfix">
					<div class="wdth50">
						<div class="form-group">
							<label>Subtitle <span class="red">*</span></label>
							<textarea id="mceFixed" name="subtitleVideo"></textarea>
						</div>
					</div>
				</div>
			</div>
			<!-- end video -->
			<!-- select slider -->
			<div class="select-slider box-method">
				<div>
					<button type="button" class="btn btn-add addSliderUrlClick">Add Image</button>
				</div>
				<div id="genUrlSlider">
					<div id="hiddenClass" class="hidden">
						<div class="row clearfix">
							<div class="wdth50">
								<div class="form-group">
									<label>Upload <span class="red">*</span></label>
									<input type="file" name="slider[]">
									<div class="mt5" style="font-size:12px;">File Type : jpg, jpeg, gif, png, pic. Resolution : 570 x 370 pixels. Maximum File Size : 1MB</div>
								</div>
							</div>
							<div class="wdth50">
								<div class="form-group">
									<label>Url <span class="red">*</span></label>
									<input type="text" class="form-control" name="urlSlider[]" />
								</div>
							</div>
						</div>
						<div class="deleteUrlSlider">
							<button class="btn btn-add">Delete Image</button>
						</div>
					</div>
					<div class="propRequired">
						<div class="row clearfix">
							<div class="wdth50">
								<div class="form-group">
									<label>Upload <span class="red">*</span></label>
									<input type="file" name="slider[]" >
									<div class="mt5" style="font-size:12px;">File Type : jpg, jpeg, gif, png, pic. Resolution : 570 x 370 pixels. Maximum File Size : 1MB</div>
								</div>
							</div>
							<div class="wdth50">
								<div class="form-group">
									<label>Url <span class="red">*</span></label>
									<input type="text" class="form-control" name="urlSlider[]" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="wdth50">
						<div class="form-group">
							<label>Subtitle <span class="red">*</span></label>
							<textarea id="mceFixed" name="subtitleSlider"></textarea>
						</div>
					</div>
				</div>
			</div>
			<!-- end slider -->
			<div>
				<a href="{{ url('meisjejongetje/pages/blog/list') }}"><button type="button" class="mr10 btn btn-pop">Back</button></a>
				<button type="submit" class="btn btn-pop hide-add">Add</button>
			</div>
		</form>
	</div>
@endsection
