<?php
// Include the database connection
include('db.php');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit;
}

// Check if the product ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Product ID not provided.";
    exit;
}

$product_id = $_GET['id'];

// Begin a transaction to ensure the integrity of the database
$conn->begin_transaction();

try {
    // First, delete related records from the order_items table
    $sql = "DELETE FROM order_items WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    if (!$stmt->execute()) {
        throw new Exception("Error deleting from order_items: " . $stmt->error);
    }
    $stmt->close();

    // Now, delete the product from the products table
    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    if (!$stmt->execute()) {
        throw new Exception("Error deleting product: " . $stmt->error);
    }
    $stmt->close();

    // Reset AUTO_INCREMENT to the highest existing product_id + 1
    $sql = "SELECT MAX(product_id) AS max_id FROM products";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $max_id = $row['max_id'];

    // If the max_id is NULL (no products left), set AUTO_INCREMENT to 1
    $next_auto_increment = $max_id ? $max_id + 1 : 1;

    // Update the AUTO_INCREMENT value
    $sql = "ALTER TABLE products AUTO_INCREMENT = $next_auto_increment";
    $conn->query($sql);

    // Commit the transaction
    $conn->commit();

    // Trigger a JavaScript alert for success
    echo "<script>alert('Product and related records deleted successfully.'); window.location.href = 'view_products.php';</script>";
} catch (Exception $e) {
    // Rollback the transaction if any error occurs
    $conn->rollback();
    echo "<script>alert('Transaction failed: " . $e->getMessage() . "'); window.location.href = 'view_products.php';</script>";
}

// Close the connection
$conn->close();
?>
