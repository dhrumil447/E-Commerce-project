<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include required files
require 'db.php';
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "watchdemo"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get Order ID from GET or POST
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

if ($order_id) {
    // Fetch order and customer details
   

$sql = "SELECT o.order_id, o.payment_method, o.total_amount, 
c.username, c.email, c.address, c.city, c.district, c.state, c.zipCode, c.phone, 
p.name, p.price, oi.quantity
FROM orders o
JOIN order_items oi ON o.order_id = oi.order_id
JOIN products p ON oi.product_id = p.product_id
JOIN cust_registration c ON o.cust_id = c.cust_id
WHERE o.order_id = ?";

    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Prepare dynamic data
        $order = [];
        while ($row = $result->fetch_assoc()) {
            $order['order_id'] = $row['order_id'];
            $order['payment_method'] = $row['payment_method'];
            $order['total_amount'] = $row['total_amount'];
            $order['name'] = $row['username'];
            $order['email'] = $row['email'];
            $order['address'] = $row['address'];
            $order['city'] = $row['city'];
            $order['district'] = $row['district'];
            $order['state'] = $row['state'];
            $order['zipCode'] = $row['zipCode'];
            $order['phone'] = $row['phone'];
            $order['items'][] = [
                'name' => $row['name'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
            ];
        }

        

        try {
            $mail = new PHPMailer(true);

            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'watchvouge9@gmail.com'; // Your email
            $mail->Password = 'ckio aava yjxa gdxn'; // Your email password or app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Sender and Recipient
            $mail->setFrom('watchvouge9@gmail.com', 'Watch Vouge Store');
            $mail->addAddress($order['email'], $order['name']); // Customer's email and name

            // Email Content
            $mail->isHTML(true);
            $mail->Subject = "Order Confirmation - Order #{$order['order_id']}";

            // HTML Body
            $body = "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <style>
                    /* Global Styles */
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f8f9fa;
                        color: #333;
                    }
            
                    .email-container {
                        max-width: 700px;
                        margin: 30px auto;
                        background-color: #ffffff;
                        border: 1px solid #ddd;
                        border-radius: 8px;
                        overflow: hidden;
                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                    }
            
                    /* Header */
                    .email-header {
                        background-color: #007BFF;
                        color: white;
                        text-align: center;
                        padding: 20px;
                    }
            
                    .email-header h1 {
                        margin: 0;
                        font-size: 24px;
                        text-transform: uppercase;
                    }
            
                    .email-header p {
                        font-size: 14px;
                        margin: 5px 0 0;
                    }
            
                    /* Body */
                    .email-body {
                        padding: 20px;
                        line-height: 1.6;
                    }
            
                    .email-body h3 {
                        color: #007BFF;
                        margin-bottom: 15px;
                        font-size: 18px;
                    }
            
                    .email-body table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 20px;
                    }
            
                    .email-body table th,
                    .email-body table td {
                        text-align: left;
                        border: 1px solid #ddd;
                        padding: 10px;
                    }
            
                    .email-body table th {
                        background-color: #f2f2f2;
                        font-weight: bold;
                    }
            
                    .email-body table .text-right {
                        text-align: right;
                    }
            
                    .email-body .total-amount {
                        font-size: 16px;
                        font-weight: bold;
                        text-align: right;
                    }
            
                    /* Footer */
                    .email-footer {
                        text-align: center;
                        background-color: #f2f2f2;
                        padding: 10px;
                        font-size: 12px;
                        color: #666;
                    }
            
                    .email-footer a {
                        color: #007BFF;
                        text-decoration: none;
                    }
            
                    /* Highlight */
                    .highlight {
                        color: #000000;
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <!-- Header -->
                    <div class='email-header'>
                        <h1>Order Confirmation</h1>
                        <p>Thank you for shopping with us, <span class='highlight'>{$order['name']}</span>!</p>
                    </div>
            
                    <!-- Body -->
                    <div class='email-body'>
                        <h3>Customer Details</h3>
                        <table>
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{$order['name']}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{$order['email']}</td>
                            </tr>
                            <tr>
                                <td><strong>Phone:</strong></td>
                                <td>{$order['phone']}</td>
                            </tr>
                            <tr>
                                <td><strong>Address:</strong></td>
                                <td>{$order['address']}, {$order['city']}, {$order['district']}, {$order['state']} - {$order['zipCode']}</td>
                            </tr>
                        </table>
            
                        <h3>Order Details</h3>
                        <table>
                            <tr>
                                <td><strong>Order ID:</strong></td>
                                <td>{$order['order_id']}</td>
                            </tr>
                            <tr>
                                <td><strong>Payment Method:</strong></td>
                                <td>{$order['payment_method']}</td>
                            </tr>
                        </table>
            
                        <h3>Order Summary</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                 </tr>";
            foreach ($order['items'] as $item) {
                $body .= "
                            <tr>
                                <td>{$item['name']}</td>
                                <td>{$item['quantity']}</td>
                                <td>₹{$item['price']}</td>
                            </tr>";
            }
                                
                               
                              
                                 $body .= " <tr>
                                    <td colspan='2' class='text-right'><strong>Total Amount:</strong></td>
                                    <td class='total-amount'>₹{$order['total_amount']}</td>
                                </tr>
                            </tbody>
                        </table>
            
                        <p>If you have any questions, feel free to <a href='mailto:watchvouge9@gmail.com'>contact us</a>.</p>
                    </div>
            
                    <!-- Footer -->
                    <div class='email-footer'>
                        <p>&copy; 2024 Watch Vouge. All rights reserved.</p>
                        <p><a href='https://yourstore.com'>Visit our website</a> for more amazing products.</p>
                    </div>
                </div>
            </body>
            </html>";
            

            $mail->Body = $body;

            // Send the email
            $mail->send();

            // Display popup message and redirect
            echo "<script>
                alert('Order confirmation email sent successfully!');
                window.location.href = 'generate_invoice.php';
            </script>";
        } catch (Exception $e) {
            echo "<script>
                alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}');
                window.location.href = 'generate_invoice.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('No order details found for Order ID: $order_id.');
            window.location.href = 'generate_invoice.php';
        </script>";
    }
    $stmt->close();
} else {
    echo "<script>
        alert('Order ID is missing.');
        window.location.href = 'generate_invoice.php';
    </script>";
}

$conn->close();
?>
