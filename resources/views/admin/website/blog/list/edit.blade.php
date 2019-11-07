@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('#blog > ul.submenu').addClass ('open');
		$('li#blog').addClass ('open');
		$('#blog-list').addClass ('active');

		var clrIndex = {{ count($list->images) }};

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

		$('.deleteUrlSlider').click(function(){
			$('#clr'+$(this).attr('data-value')).remove();
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
		<div class="title">Edit List</div>
		<form method="post" enctype="multipart/form-data" action="{{ url('meisjejongetje/pages/blog/editlist/submit') }}" novalidate>
			{{ csrf_field() }}
			<div class="clearfix row">
				<div class="wdth50">
					<div class="form-group">
						<label>Category <span class="red">*</span></label>
						<select class="form-control" id="category" name="categoryId">
							@foreach($demors as $demor)
								<option value="{{$demor->categoryid}}" @if($demor->categoryid == $list->categoryid) selected @endif>{{$demor->categoryname}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="wdth50">
					<div class="form-group">
						<label>Blog Name <span class="red">*</span></label>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="blogId" value="{{ $list->blogid }}">
						<input type="text" class="form-control" name="blogName" value="{{$list->name}}" required />
					</div>
				</div>
			</div>
			<div class="clearfix row">
				<div class="wdth50">
					<div class="form-group">
						<label>Methods <span class="red">*</span></label>
						<select class="form-control" id="select-method" name="methods" readonly >
							<option>Select Method</option>
							<option value="select-image" @if($list->method == 'select-image') selected @endif>Image Static</option>
							<option value="select-video" @if($list->method == 'select-video') selected @endif>Video</option>
							<option value="select-slider" @if($list->method == 'select-slider') selected @endif>Slider</option>
						</select>
					</div>
				</div>
			</div>
			<!-- IMAGE STATIC -->
			<div class="select-image box-method">
				<div class="clearfix row">
					<div class="wdth50">
						<div class="form-group">
							<label>Upload <span class="red">*</span></label>
							<div><img style="width: 250px; margin-bottom: 10px;" src=""/></div>
							<input type="file" name="imageStatic">
							<div class="mt5" style="font-size: 12px;">File Type : jpg, jpeg, gif, png, pic. Resolution : 570 x 370 pixels. Maximum File Size : 1MB</div>
						</div>
					</div>
					<div class="wdth50">
						<div class="form-group">
							<label>Url <span class="red">*</span></label>
							<input type="text" class="form-control" name="urlImageStatic" value=""/>
						</div>
					</div>
				</div>
				<div class="clearfix row">
					<div class="wdth50">
						<div class="form-group">
							<label>Subtitle <span class="red">*</span></label>
							<textarea id="mceFixed" name="subtitleImageStatic">{{$list->description}}</textarea>
						</div>
					</div>
				</div>
			</div>
			<!-- END IMAGE STATIC -->
			<!-- SELECT VIDEO -->
			<div class="select-video box-method">
				<div class="form-group">
					<label>Upload (Optional)</label><br>
					<input type="file" name="video">
					<div class="mt5">File Type : mp4, avi</div>
					<div>Pic Resolution : 570 x 370 pixels</div>
				</div>
				<div class="form-group">
					<label>YouTube Video (Embed) <span class="red">*</span></label>
					<input type="text" class="form-control" style="width:50%;" name="youtube" value="@if(!empty($list->images)){{ $list->images[0]->youtubepath.'?rel=0' }}@endif" />
				</div>
				<div class="clearfix row">
					<div class="wdth50">
						<div class="form-group">
							<label>Subtitle <span class="red">*</span></label>
							<textarea id="mceFixed" name="subtitleVideo">{{$list->description}}</textarea>
						</div>
					</div>
				</div>
			</div>
			<!-- END VIDEO -->
			<!-- SELECT SLIDER -->
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
									<input type="text" class="form-control" name="urlSlider[]"/>
								</div>
							</div>
						</div>
						<div class="deleteUrlSlider">
							<button class="btn btn-add">Delete Image</button>
						</div>
					</div>
					@foreach($list->images as $i => $image)
						<div class="row clearfix" id="clr{{$i}}">
							<div class="wdth50">
								<div class="form-group" style="margin-bottom: 10px;">
									<input type="hidden" name="editslider[]" value="{{ url($image->filepath ?? '') }}" >
									<div><img style="width: 250px;" src="{{ url($image->filepath ?? '') }}" /></div>
								</div>
								<div class="deleteUrlSlider" data-value="{{ $i }}">
									<button type="button" class="btn btn-add">Delete Image</button>
								</div>
							</div>
							<div class="wdth50">
								<div class="form-group">
									<label>Url <span class="red">*</span></label>
									<input type="text" class="form-control" name="urlSlider[]" value="{{ $image->urlpath ?? '' }}" required />
								</div>
							</div>
						</div>
					@endforeach
				</div>
				<div class="row clearfix">
					<div class="wdth50">
						<div class="form-group">
							<label>Subtitle <span class="red">*</span></label>
							<textarea id="mceFixed" name="subtitleSlider">{{$list->description}}</textarea>
						</div>
					</div>
				</div>
			</div>
			<!-- END SLIDER -->
			<div>
				<a href="{{ url('meisjejongetje/pages/blog/list') }}"><button type="button" class="btn btn-pop mr10">Back</button></a>
				<button type="submit" class="btn btn-pop hide-add ">Edit</button>
			</div>
		</form>
	</div>
@endsection
