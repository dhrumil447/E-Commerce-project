<?php
session_start();

if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    // Check if product is in the cart
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['product_id'] == $product_id) {
                // Remove product from cart
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        // Re-index array after removal
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

// Redirect back to the cart page
header("Location: cart.php");
exit();
?>
