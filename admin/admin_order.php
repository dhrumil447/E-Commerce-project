<?php 
session_start();
include('db.php'); // Include database connection

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit;
}

// Fetch all orders
$order_query = "
    SELECT 
        o.order_id, 
        o.total_amount, 
        o.payment_method, 
        o.payment_details, 
        o.order_status, 
        p.name AS product_name, 
        oi.quantity, 
        (oi.quantity * p.price) AS product_total, -- Total price per product
        c.username AS customer_name, 
        c.cust_id,
        c.phone, 
        c.address, 
        c.city, 
        c.district, 
        c.zipCode
    FROM orders o
    INNER JOIN order_items oi ON o.order_id = oi.order_id
    INNER JOIN products p ON oi.product_id = p.product_id
    INNER JOIN cust_registration c ON o.cust_id = c.cust_id
    ORDER BY o.order_id DESC";

$order_result = $conn->query($order_query);

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['order_status'];

    $update_query = "UPDATE orders SET order_status = '$new_status' WHERE order_id = '$order_id'";
    if ($conn->query($update_query)) {
        $success_message = "Order status updated successfully.";
        header("Refresh:0"); // Refresh to show updated data
    } else {
        $error_message = "Error updating status: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); ?>
</head>
<body>
<?php include('includes/header.php'); ?>    
   

    <div class="content">
        <h1>Recent Order Management</h1>

        <!-- Success/Error Messages -->
        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php } elseif (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

        <!-- Orders Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Product Total</th>
                        <th>Payment Method</th>
                        <th>Order Status</th>
                        <th>Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($order_result && $order_result->num_rows > 0) { ?>
                        <?php while ($row = $order_result->fetch_assoc()) { ?>
                            <tr>
                               <td>
                               <?php echo $row['order_id']; ?>
                               </td>
                                <td>
                                    <?php echo $row['cust_id']; ?>
                                    <?php echo $row['customer_name']; ?><br>
                                    <small class="text-muted">(<?php echo $row['phone']; ?>)</small>
                                </td>
                                <td>
                                    <?php echo $row['address']; ?><br>
                                    <small><?php echo $row['city'] . ', ' . $row['district'] . ' - ' . $row['zipCode']; ?></small>
                                </td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td>₹<?php echo number_format($row['product_total'], 2); ?></td>
                                <td><?php echo $row['payment_method']; ?></td>
                                <td>
                                    <span class="badge 
                                        <?php 
                                            switch ($row['order_status']) {
                                                case 'Pending': echo 'badge-warning'; break;
                                                case 'Confirmed': echo 'badge-info'; break;
                                                case 'Shipped': echo 'badge-primary'; break;
                                                case 'Out for Delivery': echo 'badge-secondary'; break;
                                                case 'Delivered': echo 'badge-success'; break;
                                                case 'Rejected': echo 'badge-success'; break;
                                                case 'Canceled': echo 'badge-danger';break;
                                                default: echo 'badge-dark'; break;
                                            }
                                        ?>">
                                        <?php echo ucfirst($row['order_status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                        <div class="input-group">
                                            <select class="form-select" name="order_status" required>
                                                <option value="Pending" <?php echo $row['order_status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="Confirmed" <?php echo $row['order_status'] === 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                                <option value="Shipped" <?php echo $row['order_status'] === 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                                <option value="Out for Delivery" <?php echo $row['order_status'] === 'Out for Delivery' ? 'selected' : ''; ?>>Out for Delivery</option>    
                                                <option value="Delivered" <?php echo $row['order_status'] === 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                                <option value="Rejected" <?php echo $row['order_status'] === 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                            </select>
                                            <button type="submit" name="update_status" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="9" class="text-center">No orders found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>   

   </body>
</html>
