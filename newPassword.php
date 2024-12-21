<?php
// require "./backend/generateOtp.php";

// if (!isset($_SESSION['varify'])) {
//     header("location: ./forgetPassword.php");
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
</head>

<body>
    <!-- Start Header Area -->
    <?php include('header.php'); ?>
    <!-- End Header Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Login/Register</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="index.php">Login/Register</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>


<div class="forgetPassword" id="forgetPassword">

    <!----------------
      otp - start 
    ----------------->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Enter New Password</h3>
                    </div>
    

      
                    
                <?php if (isset($_REQUEST['passwordError'])) { ?>
                    <div class="errorMessage">
                        <?php echo $_REQUEST['passwordError']; ?>
                    </div>
                <?php } ?>
                <?php if (isset($_REQUEST['eupdateErrormpty'])) { ?>
                    <div class="errorMessage">
                        <?php echo $_REQUEST['updateError']; ?>
                    </div>
                <?php } ?>
                <?php if (isset($_REQUEST['redirectError'])) { ?>
                    <div class="errorMessage">
                        <?php echo $_REQUEST['redirectError']; ?>
                    </div>
                <?php } ?>
                <?php if (isset($_REQUEST['emptyError'])) { ?>
                    <div class="errorMessage">
                        <?php echo $_REQUEST['emptyError']; ?>
                    </div>
                <?php } ?>
                    <form action="./generateOtp.php" method="post">
                        <h3>Enter Paasword</h3>
                        <div class="newPassword">
                            <input type="password"  class="form-control" name="newPassword" placeholder="New password">
                            <input type="password"  class="form-control" name="conformpassword" placeholder="Conform password"><br>
                        </div>
                        <div>
                            <button type="submit" class="primary-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

                </div>


       
         <?php include('footer.php'); ?>

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/countdown.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<!--gmaps Js-->
    <script src="./Assets/js/forgetPassword.js"></script>


<script src="https://kit.fontawesome.com/a669b51611.js" crossorigin="anonymous"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="js/gmaps.min.js"></script>
	<script src="js/main.js"></script>
    <script src="https://kit.fontawesome.com/a669b51611.js" crossorigin="anonymous"></script>

    </body>

</html>