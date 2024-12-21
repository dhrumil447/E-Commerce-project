<?php
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

// Validate if email already exists
$sql = "SELECT * FROM cust_registration WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Email already exists, show an error message
    echo "<script>alert('This email is already registered. Please use a different email.');window.location.href='registration.php';</script>";
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
        echo "<script>alert('Passwords do not match!');window.location.href='registration.php';</script>";
    }
}

$conn->close();
?>
