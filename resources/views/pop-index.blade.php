<div class="overlay">
	<div class="fancybox-outer">
			<!-- IF ADMIN CHOOSE BANNER, SHOW LINE 23, IF ADMIN CHOOSE TEXT, JUST COMMENT LINE 23 -->
			@if($popup->popup_type == 1)
				<div class="fancybox-inner" style="overflow: auto; width: 670px; height: auto;">
					<div class="table-newsletter clearfix" style="position:relative;padding:85px 50px 95px;">
						<div class="ori-font">{!! $popup->message !!}</div>
					</div>
				</div>
			@else
			<div class="text-center"><img src="{{ url($popup->image_path) }}" height="350" width="670"> </div>
			@endif
	</div>
</div>
