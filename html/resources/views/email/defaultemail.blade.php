
<div style="width: 500px; background: white; border: 1px solid #acacac; margin: 0 auto;">
    <div style="margin: 25px auto;text-align: center; padding-bottom: 25px; border-bottom: 1px solid #b69bbc;">
        <a href="{{ url('/') }}" target="_blank">
			<img src="{{ url('assets/images/icons/logo.png') }}" style="width:180px;"/>
		</a>
    </div>
    <div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-weight: bold; font-size: 20px; color: #424242;text-align: center; line-height: 25px;">{!! $data['title'] !!}</div>
    <div style="margin: 30px auto;text-align: center;">
        <img src="{{ $data['image'] }}"/>
    </div>
    <div style=" padding: 0 50px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242;text-align: justify; line-height: 25px;">
	{!! $data['body'] !!}
    </div>
	@if(!empty($data['action']))
	<a href="{{$data['action']}}" target="_blank" style="display: block; text-decoration: none; ">
		<div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; background: #6d3779; color: white; display: block; width: 205px; font-size: 14px; margin: 30px auto; padding: 12px 5px; font-weight: bold; text-align: center; border-radius: 5px;">{{$data['actionText']}}</div>
	</a>
	@endif
	@include('email/footer')
</div>