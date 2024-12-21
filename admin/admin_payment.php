<?php
// admin_payments.php
include('db.php');

// Check if the form has been submitted to update the payment status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_id']) && isset($_POST['payment_status'])) {
    // Get the posted payment details
    $payment_id = $_POST['payment_id'];
    $payment_status = $_POST['payment_status'];

    // Update the payment status in the database
    $update_query = "UPDATE payments SET payment_status = ? WHERE payment_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $payment_status, $payment_id);

    if ($stmt->execute()) {
        $success_message = "Payment status updated successfully!";
    } else {
        $error_message = "Error updating payment status: " . $conn->error;
    }
}

// Fetch all payments

$payments_query = "SELECT payments.payment_id, payments.order_id, cust_registration.username, 
                   payments.payment_method, payments.payment_details, payments.payment_status, payments.created_at 
                   FROM payments 
                   INNER JOIN cust_registration ON payments.cust_id = cust_registration.cust_id
                   ORDER BY payments.created_at DESC";


$payments_result = $conn->query($payments_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); ?>
</head>
<body>
<?php include('includes/header.php'); ?>    
   

    <div class="content">
    <h1>Payment Management</h1>
    
    <?php if (isset($success_message)) { ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php } elseif (isset($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php } ?>

    <div class="table-responsive">
            <table class="table table-bordered">
            <tr>
                <th>Payment ID</th>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Method</th>
                <th>Details</th>
                <th>Status</th>
                <th>Actions</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($payments_result->num_rows > 0) {
                while ($row = $payments_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['payment_id']; ?></td>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo $row['payment_method']; ?></td>
                    <td><?php echo htmlspecialchars($row['payment_details']); ?></td>
                    <td><?php echo $row['payment_status']; ?></td>
                    <td>
                        <form method="POST" action="admin_payment.php">
                            <input type="hidden" name="payment_id" value="<?php echo $row['payment_id']; ?>">
                            <select class="form-select" name="payment_status">
                                <option value="Pending" <?php echo ($row['payment_status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Accepted" <?php echo ($row['payment_status'] === 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
                                <option value="Rejected" <?php echo ($row['payment_status'] === 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-primary">Update</button>
                        </form>
                    </td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php } } else { ?>
            <tr>
                <td colspan="8">No payments found.</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
