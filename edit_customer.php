<?php
session_start();
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

// Get customer ID securely
$cust_id = isset($_GET['cust_id']) ? intval($_GET['cust_id']) : 0;

// Fetch customer details
$sql = "SELECT * FROM cust_registration WHERE cust_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

// Ensure customer data exists
if (!$customer) {
    echo "<div class='alert alert-danger text-center'>Customer not found.</div>";
    exit;
}

// Update details if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipCode = $_POST['zipCode'];

    // Update query
    $update_sql = "UPDATE cust_registration SET username = ?, email = ?, phone = ?, address = ?, city = ?, state = ?, zipCode = ? WHERE cust_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssssi", $username, $email, $phone, $address, $city, $state, $zipCode, $cust_id);

    if ($update_stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Profile updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error updating profile. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 form-container">
            <h2 class="text-center">Edit Profile</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($customer['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($customer['address']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($customer['city']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" class="form-control" id="state" name="state" value="<?php echo htmlspecialchars($customer['state']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="zipCode">Zip Code</label>
                    <input type="text" class="form-control" id="zipCode" name="zipCode" value="<?php echo htmlspecialchars($customer['zipCode']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                <a href="myprofile.php" class="btn btn-secondary btn-block">Cancel</a>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
