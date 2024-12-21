<?php
session_start();
include('db.php'); // Include database connection

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please log in to view your cart.'); window.location.href = 'login.php';</script>";
    exit();
}

// Fetch cust_id using the email from session
$email = $_SESSION['email'];
$query = "SELECT cust_id FROM cust_registration WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cust_id = $row['cust_id'];
} else {
    echo "<script>alert('User not found.'); window.location.href = 'login.php';</script>";
    exit();
}

// Handle item removal
if (isset($_GET['remove'])) {
    $product_id = intval($_GET['remove']);
    $delete_query = "DELETE FROM cart WHERE cust_id = ? AND product_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $cust_id, $product_id);
    $stmt->execute();
    echo "<script>alert('Item removed from cart.'); window.location.href = 'cart.php';</script>";
    exit();
}

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $product_id => $quantity) {
        $quantity = intval($quantity);
        if ($quantity > 0) {
            $update_query = "UPDATE cart SET quantity = ? WHERE cust_id = ? AND product_id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("iii", $quantity, $cust_id, $product_id);
            $stmt->execute();
        }
    }
    echo "<script>alert('Cart updated successfully.'); window.location.href = 'cart.php';</script>";
    exit();
}

// Fetch cart items
$query = "SELECT c.product_id, c.quantity, p.name, p.price, p.image 
          FROM cart c 
          JOIN products p ON c.product_id = p.product_id 
          WHERE c.cust_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head.php'); ?>
    <title>View Cart</title>
</head>
<body>
    <?php include('header.php'); ?>

    <!-- Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shopping Cart</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="cart.php">Cart</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Cart Area -->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <?php if ($result->num_rows > 0): ?>
                    <form method="POST">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $grand_total = 0;
                                    while ($row = $result->fetch_assoc()):
                                        $total = $row['price'] * $row['quantity'];
                                        $grand_total += $total;
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="media">
                                                    <div class="d-flex">
                                                        <img src="admin/uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="width: 70px;">
                                                    </div>
                                                    <div class="media-body">
                                                        <p><?php echo htmlspecialchars($row['name']); ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h5>₹<?php echo htmlspecialchars($row['price']); ?>.00</h5>
                                            </td>
                                            <td>
                                                <div class="product_count">
                                                    <input type="number" name="quantities[<?php echo $row['product_id']; ?>]" value="<?php echo $row['quantity']; ?>" min="1" class="input-text qty form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <h5>₹<?php echo $total; ?>.00</h5>
                                            </td>
                                            <td>
                                                <a href="cart.php?remove=<?php echo $row['product_id']; ?>" class="btn btn-danger">Remove</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Grand Total: ₹<?php echo $grand_total; ?>.00</h4>
                            <button type="submit" name="update_cart" class="gray_btn">Update Cart</button>
                        </div>
                        <div class="checkout_btn_inner d-flex align-items-center mt-4">
                            <a href="index.php" class="gray_btn">Continue Shopping</a>
                            <a href="checkout.php" class="primary-btn">Proceed to Buy</a>
                        </div>
                    </form>
                <?php else: ?>
                    <p class="alert alert-warning">Your cart is empty. <a href="index.php">Continue Shopping</a></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include('footer.php'); ?>

   
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


