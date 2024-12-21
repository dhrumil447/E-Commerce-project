<?php
session_start();

// Check if the admin is logged in


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

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit;
}

// Get customer ID from URL
$id = $_GET['cust_id'];

// Fetch the customer details to prefill the form
$sql = "SELECT * FROM cust_registration WHERE cust_id=$id";
$result = $conn->query($sql);
$customer = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated data from form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zipCode = $_POST['zipCode'];

    // Update customer data in the database
    $sql = "UPDATE cust_registration SET 
                username='$username', 
                email='$email', 
                phone='$phone', 
                state='$state', 
                district='$district', 
                address='$address', 
                city='$city', 
                zipCode='$zipCode' 
            WHERE cust_id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php"); // Redirect to admin panel after update
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <?php include('includes/head.php'); ?>
</head>
<body>
<?php include('includes/header.php'); ?>
    <div class="container">
        <h2 class="my-4 text-center">Edit Customer</h2>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="username" value="<?php echo $customer['username']; ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $customer['email']; ?>" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="tel" class="form-control" name="phone" value="<?php echo $customer['phone']; ?>" required>
            </div>
            <div class="form-group">
                <label>State</label>
                <input type="text" class="form-control" name="state" value="<?php echo $customer['state']; ?>" required>
            </div>
            <div class="form-group">
                <label>District</label>
                <input type="text" class="form-control" name="district" value="<?php echo $customer['district']; ?>" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" name="address" value="<?php echo $customer['address']; ?>" required>
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" class="form-control" name="city" value="<?php echo $customer['city']; ?>" required>
            </div>
            <div class="form-group">
                <label>Zip Code</label>
                <input type="text" class="form-control" name="zipCode" value="<?php echo $customer['zipCode']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Customer</button>
        </form>
    </div>

    <?php include('includes/footer.php'); ?>   
</body>

</html>


