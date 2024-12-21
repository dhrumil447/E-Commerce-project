<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

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

// Get customer email securely from session
$email = $_SESSION['email'] ?? null;

// Fetch customer details from database
$sql = "SELECT * FROM cust_registration WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

// Ensure customer data exists
if (!$customer) {
    echo "<div class='alert alert-danger text-center'>Customer not found. Please check your login.</div>";
    exit;
}

// Profile photo and username
$profilePhoto = !empty($customer['profile_photo']) ? $customer['profile_photo'] : "img/profile-user.png";
$username = $customer['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <?php include('head.php'); ?>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .profile-container {
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
        }

        .profile-header {
            text-align: center;
        }

        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #6c757d;
        }

        .profile-header h4 {
            margin-top: 15px;
            font-size: 1.8rem;
            color: #343a40;
        }

        .profile-details h3 {
            font-size: 1.6rem;
            font-weight: bold;
            color: #495057;
        }

        .list-group-item {
            font-size: 1.2rem;
        }

        .btn {
            font-size: 1rem;
            padding: 10px 20px;
        }
    </style>
</head>

<body>
    <header class="header_area sticky-header">
        <?php include('header.php'); ?>
    </header>

    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>My Profile</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="myprofile.php">My Profile</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="profile-header">
                    <img src="<?php echo htmlspecialchars($profilePhoto); ?>" alt="Profile Photo">
                    <h4 class="mt-3"><?php echo htmlspecialchars($username); ?></h4>
                </div>
            </div>
            <div class="col-md-8">
                <div class="profile-container">
                    <h3 class="mb-4">Profile Details</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Username:</strong> <?php echo htmlspecialchars($customer['username']); ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($customer['email']); ?></li>
                        <li class="list-group-item"><strong>Phone:</strong> <?php echo htmlspecialchars($customer['phone']); ?></li>
                        <li class="list-group-item"><strong>Address:</strong> <?php echo htmlspecialchars($customer['address']); ?></li>
                        <li class="list-group-item"><strong>City:</strong> <?php echo htmlspecialchars($customer['city']); ?></li>
                        <li class="list-group-item"><strong>State:</strong> <?php echo htmlspecialchars($customer['state']); ?></li>
                        <li class="list-group-item"><strong>Zip Code:</strong> <?php echo htmlspecialchars($customer['zipCode']); ?></li>
                    </ul>
                    <div class="mt-4">
                        <a href="edit_customer.php?cust_id=<?php echo $customer['cust_id']; ?>" class="btn btn-primary">Edit Profile</a>
                        <a href="delete_customer.php?cust_id=<?php echo $customer['cust_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
    
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
