<?php
session_start();

// Database connection
include('includes/db.php'); // Assuming your database connection is in this file

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit;
}

// Query to get the total number of products
$query_products = "SELECT COUNT(*) AS total_products FROM products"; // Replace 'products' with your actual table name
$result_products = mysqli_query($conn, $query_products);
$row_products = mysqli_fetch_assoc($result_products);
$total_products = $row_products['total_products'];

// Query to get the total number of customers
$query_customers = "SELECT COUNT(*) AS total_customers FROM cust_registration"; // Replace 'cust_registration' with your actual table name
$result_customers = mysqli_query($conn, $query_customers);
$row_customers = mysqli_fetch_assoc($result_customers);
$total_customers = $row_customers['total_customers'];

// Query to get the total number of orders
$query_orders = "SELECT COUNT(*) AS total_orders FROM orders"; // Replace 'orders' with your actual table name
$result_orders = mysqli_query($conn, $query_orders);
$row_orders = mysqli_fetch_assoc($result_orders);
$total_orders = $row_orders['total_orders'];

// Query to get the total sales amount for confirmed orders
$query_sales = "SELECT SUM(total_amount) AS total_sales FROM orders WHERE order_status = 'Confirmed' OR order_status = 'Delivered' OR order_status = 'Shipped' OR order_status = 'Out for Delivery'"; 
$result_sales = mysqli_query($conn, $query_sales);
$row_sales = mysqli_fetch_assoc($result_sales);
$total_sales = $row_sales['total_sales'];


// Query to get the total number of pending orders
$query_pending_orders = "SELECT COUNT(*) AS total_pending_orders FROM orders WHERE order_status = 'Pending'"; // Replace 'orders' with your actual table name
$result_pending_orders = mysqli_query($conn, $query_pending_orders);
$row_pending_orders = mysqli_fetch_assoc($result_pending_orders);
$total_pending_orders = $row_pending_orders['total_pending_orders'];

// Query to get the total number of completed delivered orders
$query_delivered_orders = "SELECT COUNT(*) AS total_delivered_orders FROM orders WHERE order_status = 'Delivered'"; // Replace 'orders' with your actual table name
$result_delivered_orders = mysqli_query($conn, $query_delivered_orders);
$row_delivered_orders = mysqli_fetch_assoc($result_delivered_orders);
$total_delivered_orders = $row_delivered_orders['total_delivered_orders'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); ?> <!-- Include head file for CSS/Meta -->
    <title>Admin Dashboard</title>
</head>
<body>
    <?php include('includes/header.php'); ?> <!-- Include header file -->

    <div class="content">
        <h2>Admin Dashboard</h2>

        <!-- Summary Cards -->
        <div class="row">
        <div class="col-md-3">
    <div class="card text-white bg-primary mb-4">
        <div class="card-body">
            <a href="view_products.php" style="text-decoration: none; color: white;">
                <h5 class="card-title">Total Products</h5>
                <p class="card-text"><?php echo $total_products; ?></p>
            </a>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="card text-white bg-success mb-4">
        <div class="card-body">
            <a href="customer_management.php" style="text-decoration: none; color: white;">
                <h5 class="card-title">Total Customers</h5>
                <p class="card-text"><?php echo $total_customers; ?></p>
            </a>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="card text-white bg-danger mb-4">
        <div class="card-body">
            <a href="admin_order.php" style="text-decoration: none; color: white;">
                <h5 class="card-title">Total Orders</h5>
                <p class="card-text"><?php echo $total_orders; ?></p>
            </a>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="card text-white bg-info mb-4">
        <div class="card-body">
            <a href="#" style="text-decoration: none; color: white;">
                <h5 class="card-title">Pending Orders</h5>
                <p class="card-text"><?php echo ($total_pending_orders); ?></p>
            </a>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="card text-white bg-secondary mb-4">
        <div class="card-body">
            <a href="#" style="text-decoration: none; color: white;">
                <h5 class="card-title">Delivered Orders</h5>
                <p class="card-text"><?php echo ($total_delivered_orders); ?></p>
            </a>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="card text-white bg-warning mb-4">
        <div class="card-body">
            <a href="#" style="text-decoration: none; color: white;">
                <h5 class="card-title">Total Sales</h5>
                <p class="card-text">₹<?php echo number_format($total_sales, 2); ?></p>
            </a>
        </div>
    </div>
</div>

        </div>

        <!-- Recent Orders Table -->
        <h3>Recent Orders</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to get recent orders
                $query_recent_orders = "
                    SELECT 
                        o.order_id, 
                        c.username AS customer_name, 
                        o.order_status, 
                        o.total_amount, 
                        o.order_date 
                    FROM orders o
                    INNER JOIN cust_registration c ON o.cust_id = c.cust_id
                    ORDER BY o.order_date DESC LIMIT 5"; // Fetch the last 5 orders
                $result_recent_orders = mysqli_query($conn, $query_recent_orders);

                if ($result_recent_orders && mysqli_num_rows($result_recent_orders) > 0) {
                    while ($order = mysqli_fetch_assoc($result_recent_orders)) {
                        echo "<tr>
                                <td>{$order['customer_name']}</td>
                                <td>{$order['order_status']}</td>
                                <td>₹" . number_format($order['total_amount'], 2) . "</td>
                                <td>{$order['order_date']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No recent orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include('includes/footer.php'); ?> <!-- Include footer file -->
</body>
</html>
