<?php include '../../header.php'; ?>

<script>
$(function() {
	$('#member').addClass ('active');
});
</script>
		
	<div class="clearfix">
	
		<?php include '../../menu.php'; ?>
		
		<div class="box-right">
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
				<div class="title">View Member: <span style="margin-left: 10px;">Jane Doe</span></div>						
				<div class="content">
					<div id="tabs-container">
						<div class="clearfix">
							<div class="pull-left mr30" style="width: 170px;">
								<ul class="tabs-menu">
									<li><a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/admin/commerce/member/view.php#tab-1">Personal</a></li>
									<li><a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/admin/commerce/member/view.php#tab-2">Address</a></li>
									<li class="current"><a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/admin/commerce/member/view.php#tab-3">Order</a></li>
								</ul>
								<div>
									<a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/admin/commerce/member/view.php"><button type="button" class="btn btn-pop" style="width: 125px; margin-top: 0;">Back</button></a>
								</div>
							</div>
							<div class="pull-left">
								<div class="tab">
									<div id="tab-1" class="tab-content">										
										<div class="full-product">
											<div class="t-code">Order #1234567890</div>
											<div class="row clearfix">
												<div class="wdth50">
													<p class="htitle">Shipping</p>
													<p class="orange">On Process</p>
												</div>
												<div class="wdth50">
													<p class="htitle">Payment</p>
													<p class="orange">Pending</p>
												</div>
											</div>
											<div class="border-title"></div>
											<div class="row clearfix">
												<div class="wdth50">
													<p class="htitle">Billing Info</p>
													<p>Jane Doe</p>
													<p>+62 812 34567890</p>
													<p>+62 21 657 9831</p>
													<p>Jl. Meruya Utara Raya blok 3</p>
													<p>Jakarta Barat, 11620</p>
													<p>DKI Jakarta, Indonesia</p>
												</div>
												<div class="wdth50">
													<p class="htitle">Shipping Info</p>
													<p>Jane Doe</p>
													<p>+62 812 34567890</p>
													<p>+62 21 657 9831</p>
													<p>Jl. Meruya Utara Raya blok 3</p>
													<p>Jakarta Barat, 11620</p>
													<p>DKI Jakarta, Indonesia</p>
												</div>
											</div>
											<div class="border-title"></div>
											<div class="row clearfix">
												<div class="wdth50">
													<p class="htitle">Payment</p>
													<p>Bank Transfer</p>
												</div>
												<div class="wdth50">
													<p class="htitle">Delivery</p>
													<p>Reguler</p>
												</div>
											</div>
											<div class="border-title"></div>
												<p class="htitle">Note</p>
												<p>Bajunya tidak boleh luntur.</p>
											</div>
											<div class="mb50"></div>
											<div class="adminTable">
												<table id="table_id" style="width: 100% !important;">
													<thead>
														<tr class="no-sort">
															<td>Item</td>
															<td width="150" class="text-center">Price</td>
															<td width="80" class="text-center">Qty</td>
															<td width="200" class="text-right">Total</td>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>
																<div class="clearfix">
																	<div class="pull-left mr20">
																		<div class="w100">
																			<img src="http://localhost/demorboutique/assets/images/uploads/product01.jpg" class="img-responsive">
																		</div>
																	</div>
																	<div class="pull-left">
																		<div class="detail-product">Sweater Blue</div>
																		<div class="s-title">
																			<div>Color : Grey</div>
																			<div>Size : M</div>
																		</div>
																	</div>
																</div>
															</td>
															<td class="text-center">IDR 30.000</td>
															<td class="text-center">1</td>
															<td class="text-right">IDR 30.000</td>
														</tr>
													</tbody>
													<tfoot>
														<tr>
															<td rowspan="1" colspan="2">
																<div class="clearfix">
																	<div style="float: left; margin-right: 10px; position: relative; top: 3px;">PROMO CODE</div>
																	<div style="width: 150px; float:left;">
																		<input type="text" class="form-control" name="promo" disabled value="DEMOR DISCOUNT"/>
																	</div>
																</div>
															</td>
															<td rowspan="1" colspan="2">
																<div class="text-right">
																	<p> SUBTOTAL : IDR 30.000 </p>
																	<p> SHIPPING FEE : IDR 5.000 </p>
																	<p> TAXES : IDR 25.000 </p>
																	<p> CONVENIENCE FEE : IDR 3.000 </p>
																	<p> ORDER TOTAL : IDR 1.000 </p>
																</div>
															</td>
														</tr>
													</tfoot>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>
	</div>					

<?php include '../../footer.php'; ?>