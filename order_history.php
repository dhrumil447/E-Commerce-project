<?php
session_start();
include('db.php'); // Include database connection

// Check if the customer is logged in
if (!isset($_SESSION['cust_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

$cust_id = $_SESSION['cust_id']; // Retrieve the logged-in customer ID

// Handle Order Cancellation
// Handle Order Cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order_id'])) {
    $order_id = intval($_POST['cancel_order_id']);
    $response = ['success' => false, 'message' => ''];

    // Check if the order belongs to the logged-in customer and is pending
    $check_query = "SELECT * FROM orders WHERE order_id = '$order_id' AND cust_id = '$cust_id' AND order_status = 'Pending'";
    $check_result = $conn->query($check_query);

    if ($check_result && $check_result->num_rows > 0) {
        // Update order status to "Canceled"
        $update_query = "UPDATE orders SET order_status = 'Canceled' WHERE order_id = '$order_id'";
        if ($conn->query($update_query)) {
            $response['success'] = true;
            $response['message'] = "Order has been canceled successfully!";
        } else {
            $response['message'] = "Error updating order status: " . $conn->error;
        }
    } else {
        $response['message'] = "Order cannot be canceled. It may have already been processed or does not exist.";
    }

    echo json_encode($response);
    exit();
}

// Fetch customer orders with product details
$query = "
    SELECT 
        o.order_id, 
        o.total_amount, 
        o.order_status, 
        o.order_date, 
        GROUP_CONCAT(p.name SEPARATOR ', ') AS product_names,
        pay.payment_status AS payment_status
    FROM orders o
    INNER JOIN order_items oi ON o.order_id = oi.order_id
    INNER JOIN products p ON oi.product_id = p.product_id
    LEFT JOIN payments pay ON o.order_id = pay.order_id
    WHERE o.cust_id = '$cust_id'
    GROUP BY o.order_id
    ORDER BY o.order_date DESC";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        h1.text-primary {
            color: orange !important;
            font-weight: bold;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        table th {
            background-color: #f4f4f4;
            color: #333;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .btn-cancel {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-cancel:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include('header.php'); ?>

    <!-- Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Your Orders</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="orders.php">Your Orders</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Orders Section -->
    <div class="container mt-4">
        <h1 class="text-center text-primary">Your Orders</h1>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Products</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Payment Status</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0) { 
                        while ($row = $result->fetch_assoc()) { ?>
                        <tr id="order-row-<?php echo $row['order_id']; ?>">
                            <td><?php echo htmlspecialchars($row['product_names']); ?></td>
                            <td>₹<?php echo number_format($row['total_amount'], 2); ?></td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    <?php echo ucfirst(htmlspecialchars($row['order_status'])); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                   <?php echo ucfirst(htmlspecialchars($row['payment_status'])); ?>
                                </span>
                            </td>
                            <td><?php echo date("d M Y, h:i A", strtotime($row['order_date'])); ?></td>
                            <td>
                                <?php if (strtolower($row['order_status']) === 'pending') { ?>
                                    <button class="btn btn-sm btn-cancel" onclick="cancelOrder(<?php echo $row['order_id']; ?>)">Cancel</button>
                                <?php } else { ?>
                                    <span class="text-muted">--</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } 
                    } else { ?>
                        <tr>
                            <td colspan="5" class="text-center">No orders found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <!-- JS Dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function cancelOrder(orderId) {
            if (confirm('Are you sure you want to cancel this order?')) {
                $.ajax({
                    url: '', // Same page handles the request
                    type: 'POST',
                    data: { cancel_order_id: orderId },
                    success: function(response) {
                        const result = JSON.parse(response);
                        if (result.success) {
                            alert(result.message);
                            $("#order-row-" + orderId).remove(); // Remove row from table
                        } else {
                            alert(result.message);
                        }
                    },
                    error: function() {
                        alert("An error occurred. Please try again.");
                    }
                });
            }
        }
    </script>
</body>
</html>
