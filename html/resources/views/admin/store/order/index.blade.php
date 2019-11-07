@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {
		$('li#order').addClass ('active');

		$( ".trackingClick" ).click(function() {
			$("[name=trackingOrderNo]").val($(this).attr('data-value'));
		});

		$( ".deleteClick" ).click(function() {
			$("[name=deleteId]").val($(this).attr('data-value'));
		});
		$( ".cancelClick" ).click(function() {
			$("[name=cancelId]").val($(this).attr('data-value'));
		});

		$( ".exchangeClick" ).click(function() {
			$("[name=exchangeId]").val($(this).attr('data-value'));
		});

		$(".permitClick").click(function() {
			var data = {'orderno':$("[name=exchangeId]").val(), '_token':'{{ csrf_token() }}' };
			$("[name=permitId]").val($("[name=exchangeId]").val());

			$.ajax({
				type: "post",
				url: "{{ url('meisjejongetje/commerce/order/ajaxdetail') }}",
				data: data,
				dataType: 'json',
				success: function (data) {
					var html = "";
					for(var i = 0; i < data.orderdetail.length; i++)
					{
						html += '<div class="clearfix" style="margin-bottom: 15px;"><div class="pull-left" style="width: 30px;"><div style="height:30px;"><div class="tbl"><div class="cell"><input type="checkbox" name="checkbox[]" value="'+data.orderdetail[i].productid+'" class="check"></div></div></div></div><div class="pull-left" style="width: 150px;"><div style="height:30px;"><div class="tbl"><div class="cell">'+data.orderdetail[i].productname+'</div></div></div></div><div class="pull-left"><select class="form-control" name="qty[]"><option value="0" selected>Please Select</option>';
						for(var j = 0; j < data.orderdetail[i].quantity; j++){ html+='<option value="'+(j+1)+'">'+(j+1)+'</option>' }
						html +='</select></div></div>';
					}
					$('#detailPermitProduct').html(html);
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});

		$(".notPermitClick").click(function() {
			var data = {'orderno':$("[name=exchangeId]").val(), '_token':'{{ csrf_token() }}' };
			$("[name=notPermitId]").val('#'+$("[name=exchangeId]").val());
			$("[name=orderNo]").val($("[name=exchangeId]").val());
		});

		$(".refundClick").click(function() {
			var data = {'orderno':$("[name=exchangeId]").val(), '_token':'{{ csrf_token() }}' };
			$("[name=refundId]").val($("[name=exchangeId]").val());

			$.ajax({
				type: "post",
				url: "{{ url('meisjejongetje/commerce/order/ajaxdetail') }}",
				data: data,
				dataType: 'json',
				success: function (data) {
					var html = "";
					for(var i = 0; i < data.orderdetail.length; i++)
					{
						html += '<div class="clearfix" style="margin-bottom: 15px;"><div class="pull-left" style="width:30px;"><div style="height:30px;"><div class="tbl"><div class="cell"><input type="checkbox" name="checkbox[]" value="'+data.orderdetail[i].productid+'" class="check"></div></div></div></div><div class="pull-left" style="width: 150px;"><div style="height:30px;"><div class="tbl"><div class="cell">'+data.orderdetail[i].productname+'</div></div></div></div><div class="pull-left"><select class="form-control" name="qty[]"><option value="0" selected>Please Select</option>';
						for(var j = 0; j < data.orderdetail[i].quantity; j++){ html+='<option value="'+(j+1)+'">'+(j+1)+'</option>' }
						html +='</select></div></div>';
					}
					$('#detailRefundProduct').html(html);
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});

		$("#submitPermit").submit(function(e) {
			$("#btnPermit").html('Please Wait...');
			e.preventDefault();
			var product = [];
			var quantity = [];
			var i = 0;
			var values = $("[name^=qty]").map(function(){return $(this).val();}).get();

			$("[name^=checkbox]").each(function (){
				if($(this).prop('checked')) {
					product.push($(this).val());
					quantity.push(values[i]);
				}
				i++;
			})
			var data = {'orderno':$("[name=permitId]").val(), 'voucher':$("[name=voucher]").val(), 'product':product, 'quantity':quantity, '_token':'{{ csrf_token() }}' };

			if(product.length == 0 || quantity.length == 0)
			{
				alert('Product must be select at least one');
				$("#btnPermit").html('SUBMIT');
				return;
			}
			for(var i = 0; i < quantity.length; i++)
			{
				if(quantity[i] == 0){
					alert('Quantity must be selected');
					$("#btnPermit").html('SUBMIT');
					return;
				}
			}
			$.ajax({
				type: "post",
				url: "{{ url('meisjejongetje/commerce/order/submitpermit') }}",
				data: data,
				dataType: 'json',
				success: function (data) {
					if(data.success == true)
						location.href = "{{url('meisjejongetje/commerce/order')}}";
				},
				error: function (data) {
					console.log('Error:', data);
					$("#btnPermit").html('SUBMIT');
				}
			});
		})

		$("#submitRefund").submit(function(e) {
			$("#btnRefund").html('Please Wait...');
			e.preventDefault();
			var product = [];
			var quantity = [];
			var i = 0;
			var values = $("[name^=qty]").map(function(){return $(this).val();}).get();

			$("[name^=checkbox]").each(function (){
				if($(this).prop('checked')) {
					product.push($(this).val());
					quantity.push(values[i]);
				}
				i++;
			})
			var data = {'orderno':$("[name=refundId]").val(), 'product':product, 'quantity':quantity, '_token':'{{ csrf_token() }}' };

			if(product.length == 0 || quantity.length == 0)
			{
				alert('Product must be select at least one');
				$("#btnRefund").html('SUBMIT');
				return;
			}
			for(var i = 0; i < quantity.length; i++)
			{
				if(quantity[i] == 0){
					alert('Quantity must be selected');
					$("#btnRefund").html('SUBMIT');
					return;
				}
			}
			$.ajax({
				type: "post",
				url: "{{ url('meisjejongetje/commerce/order/submitrefund') }}",
				data: data,
				dataType: 'json',
				success: function (data) {
					console.log(data);
					location.href = "{{url('meisjejongetje/commerce/order')}}";
				},
				error: function (data) {
					console.log('Error:', data);
					$("#btnRefund").html('SUBMIT');
				}
			});
		});

		$('#submitNotPermit').submit( function(e){
			if($('[name=productName]').val() == '')
			{
				e.preventDefault();
				alert('Product name must be filled.');
				return;
			}
			else if($('[name=size]').val() == '')
			{
				e.preventDefault();
				alert('Product size must be filled.');
				return;
			}
			else if($('[name=size]').val().length > 5)
			{
				e.preventDefault();
				alert('Product size length must less than 5.');
				return;
			}
			else if($('[name=colour]').val() == '')
			{
				e.preventDefault();
				alert('Product colour must be filled.');
				return;
			}
			else if($('[name=quantity]').val() == '')
			{
				e.preventDefault();
				alert('Product quantity must be filled.');
				return;
			}
			else if(isNaN($('[name=quantity]').val()))
			{
				e.preventDefault();
				alert('Product quantity must be a numeric.');
				return;
			}
			else if($('[name=shippingCost]').val() == '')
			{
				e.preventDefault();
				alert('Shipping cost must be filled.');
				return;
			}
			else if(isNaN($('[name=shippingCost]').val()))
			{
				e.preventDefault();
				alert('Shipping cost must be a numeric.');
				return;
			}
			$("#btnNotPermit").html('Please Wait...');
		});

		$('#table_id2').DataTable({
			"order":[[6,"desc"]]
		})
	});
	</script>

	<style>
	.no-sort::after { display: none!important; }
	.no-sort { pointer-events: none!important; cursor: default!important; }
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
		<div class="title">Order</div>
		<div class="adminTable">
			<table id="table_id2">
				<thead>
					<tr class="no-sort">
						<td>Order No.</td>
						<td>Member</td>
						<td>Total</td>
						<td>Payment</td>
						<td width="150">Shipping</td>
						<td>Exchange</td>
						<td>Order Date</td>
						<td>Last Updated</td>
						<td class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					@foreach($orders as $order)
					<tr>
						<td>#{{$order->orderno}}</td>
						<td>{{$order->membername}}</td>
						<td>IDR {{str_replace(",",".",number_format($order->subtotal - $order->vouchernominal + $order->conveniencefee + $order->tax + $order->shippingfee))}}</td>
						@if($order->status == 'Pending')
							<td class="orange">Pending</td>
							<td class="orange">Pending</td>
						@elseif($order->status == 'Waiting')
							<td>
								<form method="post" action="{{ url('meisjejongetje/commerce/order/confirmpaid') }}">
									<div class="waiting red">Awaiting for payment</div>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="orderNo" value="{{$order->orderno}}" />
									<button type="submit" class="btn order1">Confirm Payment</button>
								</form>
							</td>
							<td class="orange">Pending</td>
						@elseif($order->status == 'Paid')
							<td class="green">Paid</td>
							<td>
								<div class="orange">On Process</div>
								<a class="fancybox trackingClick" href="#pop-tracking" data-value="{{$order->orderno}}"><button type="button" class="btn btn-order">Tracking no</button></a>
							</td>
						@elseif($order->status == 'Ship')
							<td class="green">Paid</td>
							<td>
								<div class="green">Shipped</div>
								<div class="track">Track No. {{$order->trackingno}}</div>
							</td>
						@elseif($order->status == 'Cancel')
							<td><div class="red">Canceled</div></td>
							<td><div class="red">Canceled</div></td>
						@endif
						<td>{{$order->exchangedate}}</td>
						<td>{{$order->insertdate}}</td>
						<td>{{$order->updatedate}}</td>
						<td class="text-center">
              @if($order->status == 'Ship' || $order->status == 'Paid')
								<a class="fancybox exchangeClick" href="#popExchange" data-value="{{$order->orderno}}">
									<div class="img-exchange"></div>
								</a>
							@endif
							<a class="link" href="{{ url('meisjejongetje/commerce/order/view/'. $order->orderno) }}">
								<div class="img-view"></div>
							</a>
							@if($order->status == 'Pending')
							<a class="fancybox cancelClick" href="#cancelOrder" data-value="{{$order->orderno}}">
								<div class="img-cancel"></div>
							</a>
							@endif
							<a class="fancybox deleteClick" href="#deleteGallery" data-value="{{$order->orderno}}">
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

<!-- TRACKING NO -->
<div id="pop-tracking" class="width-pop">
	<div class="pad-pop">
		 <div class="text-center">
			<form method="post" action="{{ url('meisjejongetje/commerce/order/shippingtracking') }}">
				<div class="form-group">
					<label>Tracking No</label>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="trackingOrderNo" />
					<input type="text" class="form-control" name="tracking" />
				</div>
				<div class="inline">
					<button type="submit" class="btn btn-sure order2">Yes</button>
				</div>
				<div class="inline">
					<button class="btn btn-cancel no-popup" type="button">No</button>
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
			<form action="{{ url('meisjejongetje/commerce/order/deleteorder') }}" method="post">
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

<!-- EXCHANGE -->
<div id="popExchange" class="width-pop">
	<div class="pad-pop">
		<div class="title-pop">Options</div>
		 <div class="text-center">
			<input type="hidden" value="" name="exchangeId" />
			<div class="inline">
				<a class="fancybox permitClick" href="#popPermit">
					<button class="btn btn-permit" type="button">Permit</button>
				</a>
			</div>
			<div class="inline">
				<a class="fancybox notPermitClick" href="#popNotPermit">
					<button class="btn btn-nopermit" type="button">Not Permit</button>
				</a>
			</div>
			<div class="inline">
				<a class="fancybox refundClick" href="#popRefund">
					<button class="btn btn-refund" type="button">Refund</button>
				</a>
			</div>
		</div>
	</div>
</div>

<!-- PERMIT -->
<div id="popPermit" class="width-pop">
	<div class="pad-pop">
		<div class="title-pop">Product Details</div>
		<div class="t-code" style="margin-bottom: 15px; font-size: 17px;">Product(s) need to exchange</div>
		<div>
			<form id="submitPermit" method="post">
				<div id="detailPermitProduct"></div>
				<div class="form-group">
					<div class="tbl">
						<div class="cell" style="width: 120px;">
							<label style="margin-bottom: 0;">Voucher Name</label>
						</div>
						<div class="cell">
							<input type="hidden" value="" name="permitId" />
							<select class="custom-select form-control" name="voucher" onchange="custom_select(this)"  style="width:150px;">
								@foreach($vouchers as $voucher)
									<option value="{{ $voucher->voucherid }}">{{ $voucher->vouchername }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<button type="submit" id="btnPermit" class="btn btn-sure" type="button" style="padding: 10px 20px; width: auto;">Submit</button>
			</form>
		</div>
	</div>
</div>

<!-- NOT PERMIT -->
<div id="popNotPermit" class="width-pop">
	<div class="pad-pop">
		<div class="t-code text-center" style="margin-bottom: 15px; font-size: 17px;">Product Details not allowed to exchanged</div>
		<form action="{{ url('meisjejongetje/commerce/order/submitnotpermit') }}" id="submitNotPermit" method="post">
			<div class="form-group">
				<div class="tbl">
					<div class="cell" style="width: 120px;">
						<label style="margin-bottom: 0;">Order No :</label>
					</div>
					<div class="cell">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="orderNo" value="">
						<input class="form-control" name="notPermitId" value="" disabled/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="tbl">
					<div class="cell" style="width: 120px;">
						<label style="margin-bottom: 0;">Product Name :</label>
					</div>
					<div class="cell">
						<input class="form-control" name="productName"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="tbl">
					<div class="cell" style="width: 120px;">
						<label style="margin-bottom: 0;">Size :</label>
					</div>
					<div class="cell">
						<input class="form-control" name="size"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="tbl">
					<div class="cell" style="width: 120px;">
						<label style="margin-bottom: 0;">Colour :</label>
					</div>
					<div class="cell">
						<input class="form-control" name="colour"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="tbl">
					<div class="cell" style="width: 120px;">
						<label style="margin-bottom: 0;">Quantity :</label>
					</div>
					<div class="cell">
						<input class="form-control" name="quantity"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="t-code text-center" style="margin-bottom: 15px; font-size: 17px;">Shipping Cost to return back</div>
				<div class="tbl">
					<div class="cell">
						<div>IDR</div>
					</div>
					<div class="cell">
						<input type="text" class="form-control" name="shippingCost" />
					</div>
				</div>
			</div>
			<div class="text-center">
				<button id="btnNotPermit" type="submit" class="btn btn-sure" type="button" style="padding: 10px 20px; width: auto;">Submit</button>
			</div>
		</form>
	</div>
</div>

<!-- REFUND -->
<div id="popRefund" class="width-pop">
	<div class="pad-pop">
		<div class="title-pop">Product Details</div>
		<div class="t-code" style="margin-bottom: 15px; font-size: 17px;">Product(s) need to refund</div>
		<div class="clearfix" style="margin-bottom: 5px;">
			<form id="submitRefund" method="post">
				<input type="hidden" value="" name="refundId" />
				<div id="detailRefundProduct"></div>
				<button type="submit" id="btnRefund" class="btn btn-sure" type="button" style="padding: 10px 20px; width: auto;">Submit</button>
			</form>
		</div>
	</div>
</div>

<!-- DELETE -->
<div id="cancelOrder" class="width-pop">
	<div class="pad-pop">
		<div class="title-pop">CANCEL</div>
		<div class="img-pop">
			<div class="pop-cancel"></div>
		</div>
		 <div class="text-center">
			<form method="post" action="{{ url('meisjejongetje/commerce/order/cancelorder') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" required name="cancelId" id="cancelId"/>
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
