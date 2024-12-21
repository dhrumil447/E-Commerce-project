<?php
// Start the session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "watchdemo";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zipCode = $_POST['zipCode'];

    // Check if all fields are filled
    if (empty($username) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword) || empty($state) || empty($district) || empty($address) || empty($city) || empty($zipCode)) {
        echo "<script>alert('All fields are compulsory. Please fill in all the details. These details will be used as order deatils so enter correct details');</script>";
    } else {
        // Validate if email already exists
        $sql = "SELECT * FROM cust_registration WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Email already exists, show an error message
            echo "<script>alert('This email is already registered. Please use a different email.');</script>";
        } else {
            // Proceed with registration if email doesn't exist
            if ($password === $confirmPassword) {
                // Hash the password using password_hash()
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert the new user into the database with hashed password
                $sql = "INSERT INTO cust_registration (username, email, phone, password, state, district, address, city, zipCode)
                        VALUES ('$username', '$email', '$phone', '$hashed_password', '$state', '$district', '$address', '$city', '$zipCode')";

                if ($conn->query($sql) === TRUE) {
                    // Show a success popup message and redirect to login page
                    echo "<script>alert('Registration successful!');window.location.href='login.php';</script>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                // Passwords don't match
                echo "<script>alert('Passwords do not match!');</script>";
            }
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
    <?php include('head.php'); ?>
</head>

<body>

    <!-- Start Header Area -->
    <?php include('header.php'); ?>
    <!-- End Header Area -->

    <!-- Start Banner Area -->
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
    <!-- End Banner Area -->

    <!--================Login Box Area =================-->
    <section class="login_box_area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <img class="img-fluid" src="img/login2.jpg" alt="Registration Image">
                        <div class="hover">
                            <h4>Are you already registered?</h4>
                            <p>If you already have an account, please log in.</p>
                            <a class="primary-btn" href="login.php">Log in</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Registration</h3>
                        <p>Please fill in all details as they are compulsory for registration.</p>
                        <form class="row login_form" action="registration.php" method="post" id="registrationForm" onsubmit="return validateForm()" novalidate="novalidate">
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email (must be @gmail.com)" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password (min. 8 characters)" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                            </div>
                            <div class="col-md-6 mb-3 form-group">
                                <input type="text" class="form-control" id="state" name="state" placeholder="State" required>
                            </div>
                            <div class="col-md-6 mb-3 form-group">
                                <input type="text" class="form-control" id="district" name="district" placeholder="District" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
                            </div>
                            <div class="col-md-6 mb-3 form-group">
                                <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                            </div>
                            <div class="col-md-6 mb-3 form-group">
                                <input type="text" class="form-control" id="zipCode" name="zipCode" placeholder="Zip Code" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" value="submit" class="primary-btn">Sign up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    function validateForm() {
        // Get form values
        var username = document.getElementById("username").value;
        var email = document.getElementById("email").value;
        var phone = document.getElementById("phone").value;
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;
        var state = document.getElementById("state").value;
        var district = document.getElementById("district").value;
        var address = document.getElementById("address").value;
        var city = document.getElementById("city").value;
        var zipCode = document.getElementById("zipCode").value;

        // Check if any field is empty
        if (username === "" || email === "" || phone === "" || password === "" || confirmPassword === "" || state === "" || district === "" || address === "" || city === "" || zipCode === "") {
            alert("All fields are compulsory. Please fill in all the details.");
            return false;  // Prevent form submission
        }

        // Email validation for @gmail.com
        if (!email.endsWith("@gmail.com")) {
            alert("Please enter a valid Gmail address that ends with '@gmail.com'.");
            return false;  // Prevent form submission
        }

        // Password length validation (min 8 characters)
        if (password.length < 8) {
            alert("Password must be at least 8 characters long.");
            return false;  // Prevent form submission
        }

        // Password and Confirm Password match validation
        if (password !== confirmPassword) {
            alert("Passwords do not match. Please make sure both passwords are the same.");
            return false;  // Prevent form submission
        }

        // If all checks pass, return true to allow form submission
        return true;
    }
</script>


    <!--================End Login Box Area =================-->

    <!-- Start Footer Area -->
    <?php include('footer.php'); ?>
    <!-- End Footer Area -->

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
