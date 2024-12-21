<!DOCTYPE html>
<html>

<head>
    <?php
	session_start();
	include('head.php');
	?>
	<style>
		.single-product img {
    width: 200px; /* Adjust width to desired size */
    height: 200px; /* Set height to maintain uniformity */
    object-fit: cover; /* Ensures the image fills the dimensions without distortion */
    border-radius: 5px; /* Optional: Gives rounded corners to images */
}

	</style>
</head>

<body id="category">

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
					<h1>Smart Watch</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="#">Men's<span class="lnr lnr-arrow-right"></span></a>
						<a href="mensmartwatch.php">Smart Watch</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->
	<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Categories</div>
					<ul class="main-categories">
						<li class="main-nav-list"><a data-toggle="collapse" href="#smartwatchcat" aria-expanded="false" aria-controls="smartwatchcat"><span
								 class="lnr lnr-arrow-right"></span>Smart Watches<span class="number">(53)</span></a>
							<ul class="collapse" id="smartwatchcat" data-toggle="collapse" aria-expanded="false" aria-controls="smartwatchcat">
								<li class="main-nav-list child"><a href="mensmartwatch.php">Noise<span class="number">(13)</span></a></li>
								<li class="main-nav-list child"><a href="mensmartwatch.php">Boat<span class="number">(09)</span></a></li>
								<li class="main-nav-list child"><a href="mensmartwatch.php">Samsung<span class="number">(17)</span></a></li>
								<li class="main-nav-list child"><a href="mensmartwatch.php">Apple<span class="number">(01)</span></a></li>
							</ul>
						</li>

						<li class="main-nav-list"><a data-toggle="collapse" href="#digitalwatchcat" aria-expanded="false" aria-controls="digitalwatchcat"><span
								 class="lnr lnr-arrow-right"></span>Digital Watches<span class="number">(53)</span></a>
							<ul class="collapse" id="digitalwatchcat" data-toggle="collapse" aria-expanded="false" aria-controls="digitalwatchcat">
								<li class="main-nav-list child"><a href="#">SKMEI<span class="number">(13)</span></a></li>
								<li class="main-nav-list child"><a href="#">Casio<span class="number">(09)</span></a></li>
								<li class="main-nav-list child"><a href="#">Fastrack<span class="number">(17)</span></a></li>
								<li class="main-nav-list child"><a href="#">Sonata<span class="number">(01)</span></a></li>
							</ul>
						</li>
						<li class="main-nav-list"><a data-toggle="collapse" href="#analogwatchcat" aria-expanded="false" aria-controls="analogwatchcat"><span
								 class="lnr lnr-arrow-right"></span>Analog Watch<span class="number">(53)</span></a>
							<ul class="collapse" id="analogwatchcat" data-toggle="collapse" aria-expanded="false" aria-controls="analogwatchcat">
								<li class="main-nav-list child"><a href="#">Titan<span class="number">(13)</span></a></li>
								<li class="main-nav-list child"><a href="#">Fastrack<span class="number">(09)</span></a></li>
								<li class="main-nav-list child"><a href="#">Fossil<span class="number">(17)</span></a></li>
								<li class="main-nav-list child"><a href="#">Timex<span class="number">(01)</span></a></li>
							</ul>
						</li>
						
					</ul>
				</div>
				<div class="sidebar-filter mt-50">
					<div class="common-filter">
						<div class="head">Color</div>
						<form action="#">
							<ul>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="black" name="color"><label for="black">Black<span>(29)</span></label></li>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="white" name="color"><label for="white">White<span>(29)</span></label></li>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="blackred" name="color"><label for="blackred">Black<span>(19)</span></label></li>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="gold" name="color"><label for="gold">Gold<span>(19)</span></label></li>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="grey" name="color"><label for="grey">Grey<span>(19)</span></label></li>
							</ul>
						</form>
					</div>
					<div class="common-filter">
						<div class="head">Price</div>
						<div class="price-range-area">
							<div id="price-range"></div>
							<div class="value-wrapper d-flex">
								<div class="price">Price:</div>
								<span>₹</span>
								<div id="lower-value"></div>
								<div class="to">to</div>
								<span>₹</span>
								<div id="upper-value"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-9 col-lg-8 col-md-7">
				<!-- Start Filter Bar -->
				<div class="filter-bar d-flex flex-wrap align-items-center">
					
					<div class="pagination">
						<a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
						<a href="#" class="active">1</a>
						<a href="#">2</a>
						<a href="#">3</a>
						<a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
						<a href="#">6</a>
						<a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
					</div>
				</div>
				<!-- End Filter Bar -->
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
    <div class="row">
	<?php
include('db.php');

$result = $conn->query("SELECT * FROM products WHERE gender = 'Women' AND category = 'Smart Watch'");
while ($row = $result->fetch_assoc()) {
	echo "<div class='col-lg-4 col-md-6'>";
    echo "<div class='single-product'>";
    echo "<a href='single-product.php?product_id=" . $row['product_id'] . "'>"; // Assuming single-product.php shows product details
	echo "<img class='img-fluid' src='admin/uploads/" . $row['image'] . "' alt='" . $row['name'] . "' style='width:200px'>";
	echo "<div class='product-details'>";
	echo "<h6>" . $row['name'] . "</h6>";
	echo "<div class='price'>";
    echo "<h6>Price: ₹" . $row['price'] . "</h6>";
    echo "</div>";
	echo "<div class='prd-bottom'>";
	echo "<form method='POST' action='cart.php'>";
    echo "<input type='hidden' name='product_id' value='" . $row['product_id'] . "'>";
    echo "<button type='submit' class='social-info' style='color:white; border-radius:5px; padding:10px 70px; border:none; font-size:16px;'>";
    echo "<span class='ti-bag'></span>";
   
    echo "</button>";
    echo "</form>";

    echo "</div>";
    echo "</div>";
    echo "</a>";
    echo "</div>";
    echo "</div>";
}
?>

    </div>
</section>

				<!-- End Best Seller -->
				<!-- Start Filter Bar -->
				
				<!-- End Filter Bar -->
			</div>
		</div>
	</div>

	

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