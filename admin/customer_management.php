<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
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

// Fetch customers from the database
$sql = "SELECT * FROM cust_registration";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <?php include('includes/head.php'); ?>
</head>
<body>
<?php include('includes/header.php'); ?>


    <div class="content">
        <h2 class="my-4 text-center">Customer Management</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>State</th>
                    <th>District</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Zip Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                              
                                <td>{$row['username']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['state']}</td>
                                <td>{$row['district']}</td>
                                <td>{$row['address']}</td>
                                <td>{$row['city']}</td>
                                <td>{$row['zipCode']}</td>
                                <td>
                                    <a href='edit_customer.php?cust_id={$row['cust_id']}' class='btn btn-primary btn-sm'>Edit</a>
                                    <a href='delete_customer.php?cust_id={$row['cust_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this customer?\");'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='10' class='text-center'>No customers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include('includes/footer.php'); ?>   

   </body>
</html>

<?php
$conn->close();
?>
