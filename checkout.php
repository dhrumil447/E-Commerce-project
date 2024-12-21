<?php
session_start();
include('db.php'); // Include database connection

// Get customer ID (Assuming user is logged in)
if (!isset($_SESSION['cust_id'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
} 
$cust_id = $_SESSION['cust_id']; // Assign cust_id
// Fetch cart details for the customer
$cart_query = "SELECT products.product_id, products.name, products.price, cart.quantity 
               FROM cart 
               INNER JOIN products ON cart.product_id = products.product_id 
               WHERE cart.cust_id = '$cust_id'";

$cart_result = $conn->query($cart_query);

// Initialize order summary variables
$order_items = [];
$total_amount = 0;
$shipping_cost = 0; // Fixed shipping cost

if ($cart_result && $cart_result->num_rows > 0) {
    while ($row = $cart_result->fetch_assoc()) {
        $order_items[] = $row;
        $total_amount += $row['price'] * $row['quantity'];
    }
    $total_amount += $shipping_cost; // Add shipping cost
} else {
    $error_message = "No items in the cart.";
}

// Fetch customer details
$customer_query = "SELECT username, phone, email, address, city, district, zipCode 
                   FROM cust_registration WHERE cust_id = '$cust_id'";
$customer_result = $conn->query($customer_query);

if ($customer_result && $customer_result->num_rows > 0) {
    $customer_data = $customer_result->fetch_assoc();
} else {
    $error_message = "Customer details not found. Please update your profile.";
}

// Handle order placement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $payment_method = $_POST['payment_method'];
    $payment_details = '';

    if ($payment_method == 'UPI') {
        $payment_details = $_POST['upi_id'];
    } elseif ($payment_method == 'COD') {
        $payment_details = 'Cash On Delivery';
    }

    $status = 'Pending';

    // Insert order details into `orders` table
    $query = "INSERT INTO orders (cust_id, total_amount, payment_method, payment_details, order_status)
              VALUES ('$cust_id', '$total_amount', '$payment_method', '$payment_details', '$status')";
    if ($conn->query($query)) {
        // Get the last inserted order ID
        $order_id = $conn->insert_id;

 // Insert payment details into `payments` table
 $payment_query = "INSERT INTO payments (order_id, cust_id, payment_method, payment_details, payment_status)
 VALUES ('$order_id', '$cust_id', '$payment_method', '$payment_details', 'Pending')";
$conn->query($payment_query);

        // Insert each cart item into `order_items` table
        foreach ($order_items as $item) {
            $product_id = $item['product_id']; // Ensure product_id is fetched from the cart
            $price = $item['price'];
            $quantity = $item['quantity'];
            $order_item_query = "INSERT INTO order_items (order_id, product_id, price, quantity) 
                                 VALUES ('$order_id', '$product_id', '$price', '$quantity')";
            $conn->query($order_item_query);
        }

        $success_message = "Order placed successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php
	include('head.php');
	?>
</head>

<body>

    <!-- Start Header Area -->
    <?php
	include('header.php');
	?>
	<!-- End Header Area -->


    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Checkout</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="single-product.php">Buy</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php } elseif (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

        <section class="checkout_area section_gap">
        <div class="container">
            <div class="billing_details">
                <div class="row">
                        <div class="col-lg-12">
                            <h3>Billing Details</h3>    
                            <form class="row contact_form" action="" method="POST">
                             <!-- Customer Details -->
                            
                             <div class="row">
    <div class="col-md-6 form-group">
        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($customer_data['username']); ?>" readonly>
    </div>
    
    <div class="col-md-6 form-group">
        <input type="text" class="form-control" name="number" value="<?php echo htmlspecialchars($customer_data['phone']); ?>" readonly>
    </div>
    <div class="col-md-12 form-group">
        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($customer_data['email']); ?>" readonly>
    </div>
    <div class="col-md-12 form-group">
        <input type="text" class="form-control" name="add1" value="<?php echo htmlspecialchars($customer_data['address']); ?>" readonly>
    </div>
    <div class="col-md-12 form-group">
        <input type="text" class="form-control" name="city" value="<?php echo htmlspecialchars($customer_data['city']); ?>" readonly>
    </div>
    <div class="col-md-12 form-group">
        <input type="text" class="form-control" name="District" value="<?php echo htmlspecialchars($customer_data['district']); ?>" readonly>
    </div>
    <div class="col-md-12 form-group">
        <input type="text" class="form-control" name="zip" value="<?php echo htmlspecialchars($customer_data['zipCode']); ?>" readonly>
    </div>
</div>

                        

             <!-- Order Summary -->
             <div class="col-lg-12">
             <div class="order_box">
                 <h2>Your Order</h2>
                            
                 <?php if (!empty($order_items)) { ?>

            <ul class="list">
            <li><a href="#">Product <span>Total</span></a></li>
            <?php foreach ($order_items as $item) { ?>
             <li>
            <a href="#"><?php echo $item['name']; ?> <span class="middle">x <?php echo $item['quantity']; ?></span>  <span class="last">₹<?php echo $item['price']; ?></span>
             </li>
            <?php } ?>
            </ul>

<ul class="list list_2">
    <li><a href="#">Shipping Charge<span>Free ₹<?php echo $shipping_cost; ?></span></a></li>
    <li><a href="#">Total <span>₹<?php echo $total_amount; ?></span></a></li>
    <?php } else { ?>
    <p>No items in the cart.</p>
    <?php } ?>
</ul>

    <!-- Payment Options -->
    <!-- Payment Options -->
<h3 class="mb-4">Payment Method</h3>
<div class="form-group">
    <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="payment_method" value="UPI" id="upi" required>
        <label class="form-check-label" for="upi">UPI</label>
    </div>
    <input type="text" class="form-control mb-3" name="upi_id" placeholder="Enter UPI ID">

    <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="payment_method" value="COD" id="cod" required>
        <label class="form-check-label" for="cod">Cash On Delivery</label>
    </div>
</div>

  

                     <!-- Submit -->
                 <button type="submit" class="primary-btn btn-lg btn-block">Place Order</button>
            </form>

                </div> 
            </div>
        </div>
    </div>
</section>
    <?php
	include('footer.php');
	?>
	<!-- End footer Area -->
    <div id="successModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); z-index:1000; padding:20px; background:white; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.2); text-align:center;">
        <h2>Success!</h2>
        <p>Order placed successfully!</p>
        <button onclick="closeModal()" style="padding:10px 20px; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer;">OK</button>
    </div>
    <div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;"></div>


    <?php if (isset($success_message)) { ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.getElementById('successModal').style.display = 'block';
                document.getElementById('overlay').style.display = 'block';
            });

            function closeModal() {
                document.getElementById('successModal').style.display = 'none';
                document.getElementById('overlay').style.display = 'none';
            }
        </script>
    <?php } ?>

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
