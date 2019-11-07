@extends('layouts.master')

@section('title', 'Page Title')

@section('content')

	<script>
	$(function() {	
		$('.nav_world').addClass('active');
	});
	</script>
	
	<div id="content">
		<div class="container">
			<div class="title30">
				<div class="title">WORLD OF DE'MOR</div>
				<div class="bdr-title no-center"></div>
			</div>
			<div class="mb40">
				<div class="breadcrumb"><a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/">HOME</a> / <a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/product/world_of_demor.php">WORLD OF DE'MOR</a> / <span class="active">EVENT</span></div>
			</div>
			<div class="row demor40">
				<div class="col-sm-6 item-demor">
					<a href="#" target="_blank">
						<div><img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/assets/images/uploads/demor01.jpg" class="img-responsive"/></div>
						<div class="text-demor">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
					</a>
				</div>
				<div class="col-sm-6 item-demor">
					<video class="responsive-video" controls>
						<source src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/assets/images/video/video01.mp4" type="video/mp4">
					</video>
					<div class="text-demor">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
				</div>
			</div>
			<div class="row demor40">
				<div class="col-sm-6 item-demor">
					<div class="pos-rel">
						<div id="owl-demo" class="owl-carousel">                  
							<div class="item">
								<a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/product/detail.php" target="_blank">
									<img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/assets/images/uploads/demor01.jpg" class="img-responsive"/>
								</a>
							</div>
							<div class="item">
								<a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/product/detail.php" target="_blank">
									<img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/assets/images/uploads/demor01.jpg" class="img-responsive"/>
								</a>
							</div>
							<div class="item">
								<a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/product/detail.php" target="_blank">
									<img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/assets/images/uploads/demor01.jpg" class="img-responsive"/>
								</a>
							</div>
						</div>
						<ul id="owlStatus">
							<li>
								<div class="currentItem"><span class="result"></span></div>
							</li>
							<li>/</li>
							<li>
								<div class="owlItems"><span class="result"></span></div>
							</li>
						</ul>
					</div>
					<div class="text-demor">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
				</div>
				<div class="col-sm-6 item-demor">
					<a href="#" target="_blank">
						<div><img src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/demorboutique/assets/images/uploads/demor01.jpg" class="img-responsive"/></div>
						<div class="text-demor">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
					</a>
				</div>		
			</div>
		</div>
	</div>

@endsection