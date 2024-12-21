<?php
include 'db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_POST['query']);

    // Fetch matching products from the database
    $sql = "SELECT product_id, name, image FROM products 
            WHERE name LIKE '%$searchQuery%' 
               OR category LIKE '%$searchQuery%'
            LIMIT 10";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $productID = htmlspecialchars($row['product_id']);
            $productName = htmlspecialchars($row['name']);
            $productImage = htmlspecialchars($row['image']);
            echo "<div>
             <a href='single-product.php?product_id=$productID'>
                    <img src='admin/uploads/$productImage' alt='$productName'>
                    <span>$productName</span>
                  </div>";
        }
    } else {
        echo "<div>No matching watches found.</div>";
    }
    exit;
}
?>
