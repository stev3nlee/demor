
<div style="width: 600px; background: white; border: 1px solid #acacac; margin: 0 auto;">
  <div style="margin: 25px auto;text-align: center; padding-bottom: 25px; border-bottom: 1px solid #b69bbc;">
      <a href="{{ url('/') }}" target="_blank">
		<img src="{{ url('assets/images/icons/logo.png') }}" style="width:180px;"/>
	</a>
  </div>
  @if(!empty($data['thumbail']))
  <div style="margin: 0 auto 30px; padding: 0 50px; text-align: center;">
    <img src="{{ $data['thumbail'] }}" style="width: 100%;"/>
  </div>
  @endif
  <div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-weight: bold; font-size: 20px; color: #424242;text-align: center; line-height: 25px;">{!! $data['title'] !!}</div>
  <div style=" padding: 0 50px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242;text-align: justify; line-height: 25px;">
{!! $data['body'] !!}
  </div>
@if(!empty($data['action']))
<a href="{{$data['action']}}" target="_blank" style="display: block; text-decoration: none; ">
	<div style="font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; background: #6d3779; color: white; display: block; width: 205px; font-size: 14px; margin: 30px auto; padding: 12px 5px; font-weight: bold; text-align: center; border-radius: 5px;">{{$data['actionText']}}</div>
</a>
@endif
@if(!empty($data['products']))
<div style="padding:0 25px; margin-bottom: 20px;">
    <div style="margin-bottom: 20px;">
        @foreach($data['products'] as $product)
        <div style="display:inline-block; width: 170px; margin: 0 5px 30px; text-align: center;">
            <a href="{{url('product/detail/'.$product[0]->productid)}}" target="_blank" style="display: block; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 12px; color: #424242; line-height: 21px; text-decoration: none;">
                <div>
                    <img src="{{ url($product[0]->mainimage) }}" style="max-width: 100%; width: 100%;"/>
                </div>
                <div style="margin: 10px 0 0;color: #1196d2;">{{ $product[0]->productname }}</div>
                @if($product[0]->discount != 0 )
                <div>IDR {{ number_format($product[0]->price - ($product[0]->price * $product[0]->discount/100)) }}</div>
                @else
                <div>IDR {{ number_format($product[0]->price) }}</div>
                @endif
                <ul style="margin: 5px 0 0 0; padding: 0; ">
                @foreach(array_unique(array_pluck($product,"colorpath")) as $color)
        					<li style="display: inline-block; margin-right: 5px;"><img src="{{url($color)}}" class="img-responsive"></li>
                @endforeach
                </ul>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif
@include('email/footer')
</div>
