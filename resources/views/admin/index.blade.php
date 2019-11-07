@extends('adminlayouts.adminmaster')

@section('title', 'Page Title')

@section('content')
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>

	<script>
	$(function() {
		$('li#dashboard').addClass ('active');
		
		var statistic = {!!json_encode($statistic)!!};
		var statisticDate = [];
		var statisticNum = [];
		
		for(var i = 0; i < statistic.length; i++)
		{
			statisticDate.push(statistic[i].date);
			statisticNum.push(parseInt(statistic[i].number));
		}
		$('.statistik').highcharts({
			title: {
				text: 'Order Summary',
				x: -20 //center
			},
			xAxis: {
				categories: statisticDate
			},
			yAxis: {
				title: {
					text: null
				}
			},
			tooltip: {
				valueSuffix: ' Orders'
			},
			legend: {
				enabled: false
			},
			series: [{
				name: 'Complete Order',
				data: statisticNum
			}]
		});
		
		$('[name=topsProduct]').change(function(){
			var data = {'stats':$(this).val(), '_token':'{{ csrf_token() }}' };
			
			$.ajax({
				type: "post",
				url: "{{ url('meisjejongetje/index/topsales') }}",
				data: data,
				dataType: 'json',
				success: function (data) {
					var html = '';
					for(var i = 0; i < data.topsales.length; i++){
						html += '<div class="clearfix bdr-sales"><div class="inline-other">'+data.topsales[i].productname+'</div></div>';
					}
					$('#topsales').html(html);
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});
		
		$('.sales').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Sales'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: {point.percentage:.1f} %',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			},
			series: [{
				name: 'Brands',
				colorByPoint: true,
				data: [{
					name: 'Microsoft Internet Explorer',
					y: 56.33
				}, {
					name: 'Chrome',
					y: 24.03,
					sliced: true,
					selected: true
				}, {
					name: 'Firefox',
					y: 10.38
				}, {
					name: 'Safari',
					y: 4.77
				}, {
					name: 'Opera',
					y: 0.91
				}, {
					name: 'Proprietary or Undetectable',
					y: 0.2
				}]
			}]
		});
		var dailyDate = [];
		var dailyNum = [];
		@php ($now = new DateTime())
		num = {{cal_days_in_month(CAL_GREGORIAN, $now->format('m'), $now->format('Y'))}};
		var daily = {!!json_encode($daily)!!};
		var j = 0;
		for(var i = 1; i <= num; i++)
		{
			dailyDate.push(i);
			if(i == daily[j].sortdate)
			{
				dailyNum.push(parseInt(daily[j].number));
				if(j != daily.length - 1)
					j++;
			}
			else
			{
				dailyNum.push(0);
			}
		}
		$('.daily-stats').highcharts({
			title: {
				text: 'Daily Stats',
				x: -20 //center
			},
			xAxis: {
				categories: dailyDate
			},
			yAxis: {
				title: {
					text: null
				}
			},
			tooltip: {
				valueSuffix: ''
			},
			legend: {
				enabled: false
			},
			series: [{
				name: 'Daily Order',
				data: dailyNum
			}]
		});
		var monthlyNum = [];
		var monthly = {!!json_encode($monthly)!!};
		j = 0;
		for(var i = 1; i <= 12; i++)
		{
			if(i == monthly[j].sortdate)
			{
				monthlyNum.push(parseInt(monthly[j].number));
				if(j != monthly.length - 1)
					j++;
			}
			else
			{
				monthlyNum.push(0);
			}
		}
		$('.monthly-stats').highcharts({
			title: {
				text: 'Monthly Stats',
				x: -20 //center
			},
			xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
					'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
			},
			yAxis: {
				title: {
					text: null
				}
			},
			legend: {
				enabled: false
			},
			tooltip: {
				valueSuffix: ''
			},
			series: [{
				name: 'Monthly Order',
				data: monthlyNum
			}]
		});
	});
	</script>

	<style>
	.mb50 { margin-bottom: 50px; }
	.mb10 { margin-bottom: 15px; }
	.bdr-sales { border-bottom: 1px solid #cecece; padding-bottom: 10px; margin-bottom: 10px; }
	.box-other { width: 100%; margin: 0 auto; }
	.inline-other { display: inline-block; }
	.t-other { font-size: 16px; font-weight: bold; color: #305a90; margin-right: 10px; }
	div.dataTables_wrapper div.dataTables_paginate, .dataTables_filter, .adminTable .dataTables_length, div.dataTables_wrapper div.dataTables_info { display: none !important; }
	</style>
	
	<div class="content">
		<div class="breadcrumb">
			<a class="active">Dashboard</a>
		</div>
		<div class="mb50">
			<div class="statistik" style="height: 300px; margin: 0 auto"></div>					
		</div>
		<div class="mb50">					
			<div class="row clearfix">
				<div class="wdth40">
					<div class="title">Sales</div>
					<div class="mb10">Here Are Your Sales For This Year:</div>
					<div class="clearfix bdr-sales">
						<div class="pull-left">Today</div>
						<div class="pull-right">Rp {{str_replace(",",".",number_format($sales->today))}}</div>
					</div>
					<div class="clearfix bdr-sales">
						<div class="pull-left">This Week</div>
						<div class="pull-right">Rp {{str_replace(",",".",number_format($sales->week))}}</div>
					</div>
					<div class="clearfix bdr-sales">
						<div class="pull-left">This Month</div>
						<div class="pull-right">Rp {{str_replace(",",".",number_format($sales->month))}}</div>
					</div>
				</div>
				<div class="wdth30">
					<div class="row clearfix">
						<div class="mb30">
							<div class="daily-stats" style="height: 150px; margin: 0 auto"></div>
						</div>
					</div>
				</div>
				<div class="wdth30">
					<div class="row clearfix">
						<div class="mb30">
							<div class="monthly-stats" style="height: 150px; margin: 0 auto"></div>
						</div>
					</div>
				</div>
			</div>					
		</div>
		<div class="mb50">
			<div class="row clearfix">
				<div class="wdth50">
					<div class="title">Top 5 Products</div>
					<div class="form-group">
						<div class="clearfix mb10">
							<div class="inline-other" style="width: 100px;">
								<label>Select the range:</label>
							</div>
							<div class="inline-other">
								<select class="custom-select form-control" name="topsProduct" onchange="custom_select(this)">
									<option value="today" selected>Today</option>
									<option value="week">This week</option>
									<option value="month">This month</option>
									<option value="year">This year</option>
								</select>
							</div>
						</div>
					</div>
					<div class="box-other" id="topsales">
						@foreach($topsales as $sales)
							<div class="clearfix bdr-sales">
								<div class="inline-other">{{$sales->productname}}</div>
							</div>
						@endforeach
					</div>
				</div>
				<div class="wdth50">
					<div class="title">Other Stats</div>
					<div class="box-other">
						<div class="clearfix bdr-sales">
							<div class="inline-other" style="width:50px;">
								<div class="t-other">{{$other->ordertotal}}</div>
							</div>
							<div class="inline-other">Total Order</div>
						</div>
						<div class="clearfix bdr-sales">
							<div class="inline-other" style="width:50px;">
								<div class="t-other">{{$other->membertotal}}</div>
							</div>
							<div class="inline-other">Total Member</div>
						</div>
						<div class="clearfix bdr-sales">
							<div class="inline-other" style="width:50px;">
								<div class="t-other">{{$other->subscribetotal}}</div>
							</div>
							<div class="inline-other">Total Subscribers</div>
						</div>
					</div>
				</div>
			</div>										
		</div>
		<div>
			<div class="title">10 Last Order</div>
			<div class="adminTable">
				<table id="table_id">
					<thead>
						<tr>
							<td>Order</td>
							<td>Member</td>
							<td>Total</td>									
							<td>Order Date</td>
							<td>Date Update</td>
							<td>Status</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
					@foreach($orders as $order)
					<tr>
						<td>#{{$order->orderno}}</td>
						<td>{{$order->membername}}</td>
						<td>IDR {{str_replace(",",".",number_format($order->subtotal - $order->vouchernominal + $order->conveniencefee + $order->tax + $order->shippingfee))}}</td>
						<td>{{$order->insertdate}}</td>
						<td>{{$order->updatedate}}</td>
						@if($order->status == 'Pending')
							<td class="orange">Pending</td>
						@elseif($order->status == 'Waiting')
							<td>
								<td class="orange">Confirm Payment</td>
							</td>
						@elseif($order->status == 'Paid')
							<td>
								<div class="orange">On Process</div>
							</td>
						@elseif($order->status == 'Ship')
							<td>
								<div class="green">Shipped</div>
								<div class="track">Track No. {{$order->trackingno}}</div>
							</td>
						@elseif($order->status == 'Cancel')
							<td><div class="red">Canceled</div></td>
						@endif
						<td class="text-center">
							<a class="link" href="{{ url('meisjejongetje/commerce/order/view/'. $order->orderno) }}">
								<div class="img-view"></div>
							</a>
						</td>
					</tr>
					@endforeach
					</tbody>
					<tfoot></tfoot>
				</table>
			</div>
		</div>
	</div>
	
@endsection