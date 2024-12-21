<?php
session_start();
include('db.php'); // Database connection file

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please log in to continue.'); window.location.href = 'login.php';</script>";
    exit();
}

// Fetch `cust_id` using the email stored in session
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

// Fetch product details
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$query = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product_result = $stmt->get_result();

if ($product_result->num_rows > 0) {
    $product = $product_result->fetch_assoc();
} else {
    echo "<script>alert('Product not found.'); window.location.href = 'index.php';</script>";
    exit();
}

// Add to cart logic
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $quantity = filter_input(INPUT_POST, 'qty', FILTER_VALIDATE_INT);

    if ($quantity > 0) {
        // Check if product is already in the cart
        $cart_query = "SELECT * FROM cart WHERE cust_id = ? AND product_id = ?";
        $cart_stmt = $conn->prepare($cart_query);
        $cart_stmt->bind_param("ii", $cust_id, $product_id);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();

        if ($cart_result->num_rows > 0) {
            // Update quantity
            $update_query = "UPDATE cart SET quantity = quantity + ? WHERE cust_id = ? AND product_id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("iii", $quantity, $cust_id, $product_id);
            $update_stmt->execute();
            $message = "Product quantity updated in cart.";
        } else {
            // Insert into cart
            $insert_query = "INSERT INTO cart (cust_id, product_id, quantity) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("iii", $cust_id, $product_id, $quantity);
            $insert_stmt->execute();
            $message = "Product added to cart!";
        }
    } else {
        $message = "Please enter a valid quantity.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
</head>

<body>

    <!-- Start Header Area -->
    <?php include('header.php'); ?>
    <!-- End Header Area -->

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Product Details Page</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                       
                        <a href="single-product.php">Product Details</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Single Product Area =================-->
    <div class="product_image_area">
        <div class="container">
            <div class="row s_product_inner">
                <!-- Product Image Carousel -->
                <div class="col-lg-6">
                    <div class="s_Product_carousel">
                        <!-- Carousel Items -->
                        <?php for ($i = 1; $i <= 3; $i++): ?>
                            <div class="single-prd-item">
                                <img class="img-fluid" src="admin/uploads/<?php echo htmlspecialchars($product['image' . $i]); ?>" alt="Product Image <?php echo $i; ?>">
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-lg-5 offset-lg-1">
                    <div class="s_product_text">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <h2>₹<?php echo htmlspecialchars($product['price']); ?></h2>
                        <ul class="list">
                            <li><span>Availability</span> : <?php echo htmlspecialchars($product['availability']); ?></li>
                            <li><span>Brand</span> : <?php echo htmlspecialchars($product['brand']); ?></li>
                            <li><span>Dimensions</span> : <?php echo htmlspecialchars($product['height']); ?> x <?php echo htmlspecialchars($product['width']); ?></li>
                            <li><span>Weight</span> : <?php echo htmlspecialchars($product['weight']); ?> g</li>
                            <li><span>Color</span> : <?php echo htmlspecialchars($product['color']); ?></li>
                            <li><span>Manufacturer</span> : <?php echo htmlspecialchars($product['manufacturer']); ?></li>
                        </ul>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <!-- Quantity Selector Form -->
                         <form action="" method="POST">
                            <div class="mb-3">
                                <label for="qty" class="form-label">Quantity</label>
                                <input class="d-flex gap-2" type="number" name="qty" id="qty" class="form-control" min="1" value="1" required>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" name="add_to_cart" class="primary-btn">Add to Cart</button>
                                <a href="cart.php" class="primary-btn">View Cart</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================End Single Product Area =================-->

    <!-- Start Footer Area -->
    <?php include('footer.php'); ?>
    <!-- End Footer Area -->

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!-- gmaps Js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>