<?php
// Include the database connection
session_start();

// Database connection
include('includes/db.php'); // Assuming your database connection is in this file

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit;
}



// Default filter set to "All"
$category_filter = isset($_GET['category']) ? $_GET['category'] : 'All';

// Query to select products based on the selected category
if ($category_filter == 'Men') {
    $sql = "SELECT * FROM products WHERE gender = 'Men'";
} elseif ($category_filter == 'Women') {
    $sql = "SELECT * FROM products WHERE gender = 'Women'";
} else {
    $sql = "SELECT * FROM products"; // Show all products when 'All' is selected
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('includes/head.php'); ?>
</head>
<body>
<?php include('includes/header.php'); ?>

   

    <div class="content">
        <h2 class="mb-4">View Products</h2>

        <!-- Dropdown for selecting the category -->
        <form method="GET" action="view_products.php" class="mb-4">
            <div class="form-group">
                <label for="category">Filter by Category:</label>
                <select name="category" id="category" class="form-control" onchange="this.form.submit()">
                    <option value="All" <?php if($category_filter == 'All') echo 'selected'; ?>>All Products</option>
                    <option value="Men" <?php if($category_filter == 'Men') echo 'selected'; ?>>Men's Watches</option>
                    <option value="Women" <?php if($category_filter == 'Women') echo 'selected'; ?>>Women's Watches</option>
                </select>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                  
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Gender</th> <!-- New Gender column -->
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any products
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                       
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>₹" . $row['price'] . "</td>";
                        echo "<td>" . $row['category'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>"; // Display the gender
                        echo "<td><img src='uploads/" . $row['image'] . "' alt='" . $row['name'] . "' style='width:100px;'></td>";
                        echo "<td>
                                <a href='edit_product.php?product_id=" . $row['product_id'] . "' class='btn btn-primary btn-sm'>Edit</a>
                                <a href='delete_product.php?id=" . $row['product_id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this product?');\">Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No products found.</td></tr>";
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>

    <?php include('includes/footer.php'); ?>   
    </body>

</html>
