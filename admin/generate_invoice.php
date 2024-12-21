<?php 
session_start();
include('includes/db.php');
require('fpdf/fpdf.php'); // Include FPDF library

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        // If not logged in, redirect to the login page
        header('Location: index.php');
        exit;
    }
    

    // Fetch order details
    $query = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    // Fetch customer details
    $customer_id = $order['cust_id'];
    $query_customer = "SELECT * FROM cust_registration WHERE cust_id = ?";
    $stmt_customer = $conn->prepare($query_customer);
    $stmt_customer->bind_param('i', $customer_id);
    $stmt_customer->execute();
    $result_customer = $stmt_customer->get_result();
    $customer = $result_customer->fetch_assoc();

    // Fetch order items
    $query_items = "SELECT * FROM order_items WHERE order_id = ?";
    $stmt_items = $conn->prepare($query_items);
    $stmt_items->bind_param('i', $order_id);
    $stmt_items->execute();
    $result_items = $stmt_items->get_result();

    // Generate invoice PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetMargins(10, 10, 10);

    // Header - Store Logo & Details
    $pdf->SetFont('Helvetica', 'B', 20);
    $pdf->SetTextColor(0, 51, 102);
     // Add your logo file here
    $pdf->Cell(120, 10, "WatchVouge Store", 0, 1, 'C');
    $pdf->SetFont('Helvetica', '', 10);
    
    $pdf->Cell(120, 5, "Email: watchvouge9@gmail.com", 0, 1, 'C');
    $pdf->Ln(5);

    // Bill Details
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(95, 8, "Bill To:", 0, 0, 'L');
    $pdf->Cell(95, 8, "Invoice #: " . $order_id, 0, 1, 'R');
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Cell(95, 5,"Name: " . $customer['username'], 0, 0, 'L');
    $pdf->Cell(95, 5, "Date: " . $order['order_date'], 0, 1, 'R');
    $pdf->Cell(95, 5,"Email: " . $customer['email'], 0, 1, 'L');
    $pdf->Cell(95, 5,"Address:" . $customer['address'], 0, 1, 'L');
    $pdf->Cell(95, 5, $customer['city'] . ", " . $customer['state'] . " " . $customer['zipCode'], 0, 1, 'L');
    $pdf->Cell(95, 5, "Phone: " . $customer['phone'], 0, 1, 'L');
        
    $pdf->Ln(10);

    // Table Header
    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Cell(80, 10, "Item", 1, 0, 'C', true);
    $pdf->Cell(30, 10, "Quantity", 1, 0, 'C', true);
    $pdf->Cell(40, 10, "Unit Price", 1, 0, 'C', true);
    $pdf->Cell(40, 10, "Total", 1, 1, 'C', true);

    // Table Data
    $pdf->SetFont('Helvetica', '', 10);
    $total_price = 0;
    while ($item = $result_items->fetch_assoc()) {
        $product_id = $item['product_id'];
        $query_product = "SELECT * FROM products WHERE product_id = ?";
        $stmt_product = $conn->prepare($query_product);
        $stmt_product->bind_param('i', $product_id);
        $stmt_product->execute();
        $result_product = $stmt_product->get_result();
        $product = $result_product->fetch_assoc();

        $item_name = $product['name'];
        $quantity = $item['quantity'];
        $unit_price = $product['price'];
        $item_total = $quantity * $unit_price;
        $total_price += $item_total;

        $pdf->Cell(80, 8, $item_name, 1, 0, 'C');
        $pdf->Cell(30, 8, $quantity, 1, 0, 'C');
        $pdf->Cell(40, 8, "" . number_format($unit_price, 2), 1, 0, 'C');
        $pdf->Cell(40, 8, "" . number_format($item_total, 2), 1, 1, 'C');
    }

    // Total
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(150, 10, "Total", 1, 0, 'R');
    $pdf->Cell(40, 10, "" . number_format($total_price, 2), 1, 1, 'C');

    // Footer Message
    $pdf->Ln(10);
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Cell(190, 5, "Thank you for your purchase!", 0, 1, 'C');
    $pdf->Cell(190, 5, "For support, contact watchvouge9@gmail.com", 0, 1, 'C');

    // Output PDF
    $pdf->Output('I', 'Invoice_' . $order_id . '.pdf');
} else {
    echo "Order ID not provided.";
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
    <h1>Confirmed Orders</h1>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch confirmed orders from the database
                $query_orders = "SELECT * FROM orders WHERE order_status = 'Confirmed'";
                $result_orders = mysqli_query($conn, $query_orders);

                while ($order = mysqli_fetch_assoc($result_orders)) {
                    $order_id = $order['order_id'];
                    $customer_id = $order['cust_id'];

                    // Fetch customer name for the order
                    $query_customer = "SELECT username FROM cust_registration WHERE cust_id = ?";
                    $stmt_customer = $conn->prepare($query_customer);
                    $stmt_customer->bind_param('i', $customer_id);
                    $stmt_customer->execute();
                    $customer_result = $stmt_customer->get_result();
                    $customer = $customer_result->fetch_assoc();
                ?>
                <tr>
                    <td>#<?php echo $order_id; ?></td>
                    <td><?php echo $customer['username']; ?></td>
                    <td><?php echo $order['order_status']; ?></td>
                    <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td>
                    <a href="generate_invoice.php?order_id=<?php echo $order_id; ?>" class="btn btn-success">Generate Invoice</a>
                    <form method="POST" action="send_invoice_email.php" style="display:inline;">
                     <a href="send_invoice_email.php?order_id=<?php echo $order_id; ?>" class="btn btn-primary">Send Email</a>
                     </form>
                   </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>
