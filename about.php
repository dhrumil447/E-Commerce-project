<!DOCTYPE html>
<html>

<head>
    <?php
	session_start();
	include('head.php');
	?>
</head>

<body>
	<!-- Start Header Area -->
	<?php 
	include('header.php');
	?>
	<!-- End Header Area -->
	
	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>About Us</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="about.php">About Us</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->
	<!-- Start Sample Area -->
	<section class="sample-text-area">
		<div class="container">
			<h3 class="text-heading">About Us</h3>
			<p class="sample-text">
				The idea for Watch Vouge came about because people were often asking us for advice about which watch they should buy.
                The more this happened — and it happened a lot — the more we realized that searching for a watch online is a minefield of information.
                Leveraging our 10 years of experience working in the watch industry, we understood the intricacies and nuances that come with selecting the perfect watch.
            </p>
            <p class="sample-text">
                The individual brand websites are great, but there are lots of watch brands in World, 
                so checking out each page individually would take you weeks, and that’s if you know the names of all the brands.
            </p>
            <p class="sample-text">
                Recognizing the need for a comprehensive platform, we created a solution. Watch Vouge is not just a website but a pioneering resource where you can effortlessly search for new watches worldwide,
                compare models, check prices, and discover new brands all in one place.
            </p>
		</div>
	</section>
	<!-- End Sample Area -->
	
	<!-- start footer Area -->
	<?php 
	include('footer.php');
	?>
	<!-- End footer Area -->


	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="js/gmaps.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>