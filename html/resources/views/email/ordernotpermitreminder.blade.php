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
        <div style="margin-bottom:15px;">Dear Customer,</div>
        <div style="margin-bottom:15px;">We noticed you haven't collected your item(s) and transfer the money yet to our Bank Account. </div>
        <div style="margin-bottom:15px;">After 3 days from today, you will no longer be able to collect your item(s). Please collect your item(s) by paying the shipping cost via Bank Transfer within 3 days. </div>
		<div style="margin-bottom: 15px;">These are the following details of your order: </div>

		<div style="padding: 0px;">
			<div style="border-top: 1px solid #b69bbc; padding-top: 30px; padding-bottom:20px; margin: 30px 0;">
				<div style="margin-bottom: 15px;">
					<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">ORDER NO.</div>
					<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">{{ $data['data']->orderheader[0]->orderno }}</div>
				</div>
				<div style="margin-bottom: 15px;">
					<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">PRODUCT NAME</div>
					<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">{{ $data['data']->ordernotpermit[0]->productname }}</div>
				</div>
				<div style="margin-bottom: 15px;">
					<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">SIZE</div>
					<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">{{ $data['data']->ordernotpermit[0]->size }}</div>
				</div>
				<div style="margin-bottom: 15px;">
					<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">COLOR</div>
					<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">{{ $data['data']->ordernotpermit[0]->colour }}</div>
				</div>
				<div style="margin-bottom: 15px;">
					<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">QUANTITY</div>
					<div style="display:inline-block; width: 190px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242; line-height: 25px; font-weight: bold;">{{ $data['data']->ordernotpermit[0]->quantity }}</div>
				</div>
			</div>
		</div>
    </div>
	<div style="padding: 0 50px;">
		<div style="border-top: 1px solid #b69bbc; padding-top: 30px; margin: 30px 0;">
  		<div style="padding: 0 0px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242;text-align: justify; line-height: 25px; margin-bottom:15px;">
  			<div>If you already done the payment via bank transfer, please confirm the payment in <a href="{{url('member/confirmpaymentshipping')}}" target="_blank">here</a>.</div>
  		</div>
  		<div style="padding: 0 0px; font : 300 14px/18px 'Lucida Grande', Lucida Sans, Lucida Sans Unicode, sans-serif, Arial, Helvetica, Verdana, sans-serif; font-size: 14px; color: #424242;text-align: justify; line-height: 25px;">Thank you for your understanding and shopping with us.</div>
	</div>
</div>
	@include('email/footer')
</div>
