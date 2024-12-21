<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "watchdemo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit;
}

// Get customer ID from URL
if (!isset($_GET['cust_id']) || empty($_GET['cust_id'])) {
    echo "Customer ID not provided.";
    exit;
}

$cust_id = intval($_GET['cust_id']);

// Begin transaction
$conn->begin_transaction();

try {
    // Delete related records in orders
    $sql = "DELETE FROM orders WHERE cust_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cust_id);
    if (!$stmt->execute()) {
        throw new Exception("Error deleting from orders: " . $stmt->error);
    }
    $stmt->close();

    // Delete the customer
    $sql = "DELETE FROM cust_registration WHERE cust_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cust_id);
    if (!$stmt->execute()) {
        throw new Exception("Error deleting customer: " . $stmt->error);
    }
    $stmt->close();

    // Commit transaction
    $conn->commit();
    echo "Customer and related records deleted successfully.";
} catch (Exception $e) {
    $conn->rollback();
    echo "Transaction failed: " . $e->getMessage();
}

$conn->close();
?>
