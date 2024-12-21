<?php
// Include database connection
include('db.php');
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit;
}


// Fetch product details based on the product ID
// Initialize variables
$product = null; // Make sure to initialize $product
$product_id = null; // Initialize $product_id as null

// Fetch product details based on the product ID
if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        // Fetch the product details
        $product = mysqli_fetch_assoc($result); // Assign to $product instead of $product_id
    }
}

// Check if the product exists
if (!$product) {
    echo "<script>alert('Product not found!'); window.location.href='view_products.php';</script>";
    exit();
}


// Check if the form is submitted for updating the product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $height = mysqli_real_escape_string($conn, $_POST['height']);
    $width = mysqli_real_escape_string($conn, $_POST['width']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $manufacturer = mysqli_real_escape_string($conn, $_POST['manufacturer']);
    
    // Handle file uploads for images (if any)
    $target_dir = "admin/uploads/";
    $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : $product['image'];
    $image1 = $_FILES['image1']['name'] ? $_FILES['image1']['name'] : $product['image1'];
    $image2 = $_FILES['image2']['name'] ? $_FILES['image2']['name'] : $product['image2'];
    $image3 = $_FILES['image3']['name'] ? $_FILES['image3']['name'] : $product['image3'];

    // Move uploaded files if they exist
    if ($_FILES['image']['name']) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);
    }
    if ($_FILES['image1']['name']) {
        move_uploaded_file($_FILES['image1']['tmp_name'], $target_dir . $image1);
    }
    if ($_FILES['image2']['name']) {
        move_uploaded_file($_FILES['image2']['tmp_name'], $target_dir . $image2);
    }
    if ($_FILES['image3']['name']) {
        move_uploaded_file($_FILES['image3']['tmp_name'], $target_dir . $image3);
    }

    // Prepare SQL statement to update the product
    $sql = "UPDATE products SET 
            name='$name', 
            description='$description', 
            price='$price', 
            category='$category', 
            gender='$gender', 
            availability='$availability', 
            brand='$brand', 
            height='$height', 
            width='$width', 
            weight='$weight', 
            color='$color', 
            manufacturer='$manufacturer', 
            image='$image', 
            image1='$image1', 
            image2='$image2', 
            image3='$image3' 
            WHERE product_id = $product_id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product updated successfully!'); window.location.href='view_products.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href='edit_product.php?product_id=$product_id';</script>";
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<head>
    <?php include('includes/head.php'); ?>
</head>
<body>
<?php include('includes/header.php'); ?>
    

    <div class="content">
        <h2 class="mb-4">Edit Product</h2>
        <div class="container">
            <form action="edit_product.php?product_id=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" step="0.01" class="form-control" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="availability">Availability:</label>
                    <select id="availability" name="availability" class="form-control" required>
                        <option value="In Stock" <?php echo ($product['availability'] == 'In Stock') ? 'selected' : ''; ?>>In Stock</option>
                        <option value="Out of Stock" <?php echo ($product['availability'] == 'Out of Stock') ? 'selected' : ''; ?>>Out of Stock</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="brand">Brand:</label>
                    <input type="text" id="brand" name="brand" class="form-control" value="<?php echo htmlspecialchars($product['brand']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="height">Height (cm):</label>
                    <input type="number" id="height" name="height" class="form-control" value="<?php echo htmlspecialchars($product['height']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="width">Width (cm):</label>
                    <input type="number" id="width" name="width" class="form-control" value="<?php echo htmlspecialchars($product['width']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="weight">Weight (g):</label>
                    <input type="number" id="weight" name="weight" class="form-control" value="<?php echo htmlspecialchars($product['weight']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="color">Color:</label>
                    <input type="text" id="color" name="color" class="form-control" value="<?php echo htmlspecialchars($product['color']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="manufacturer">Manufacturer:</label>
                    <input type="text" id="manufacturer" name="manufacturer" class="form-control" value="<?php echo htmlspecialchars($product['manufacturer']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select id="category" name="category" class="form-control" required>
                        <option value="Smart Watch" <?php echo ($product['category'] == 'Smart Watch') ? 'selected' : ''; ?>>Smart Watch</option>
                        <option value="Digital Watch" <?php echo ($product['category'] == 'Digital Watch') ? 'selected' : ''; ?>>Digital Watch</option>
                        <option value="Analouge Watch" <?php echo ($product['category'] == 'Analouge Watch') ? 'selected' : ''; ?>>Analouge Watch</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option value="Men" <?php echo ($product['gender'] == 'Men') ? 'selected' : ''; ?>>Men</option>
                        <option value="Women" <?php echo ($product['gender'] == 'Women') ? 'selected' : ''; ?>>Women</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" class="form-control-file">
                    <img src="uploads/<?php echo $product['image']; ?>" alt="Current Image" style="width: 150px; height: auto;">
                </div>
                <div class="form-group">
                    <label for="image1">Additional Image 1:</label>
                    <input type="file" id="image1" name="image1" class="form-control-file">
                    <img src="uploads/<?php echo $product['image1']; ?>" alt="Current Image" style="width: 150px; height: auto;">
                </div>
                <div class="form-group">
                    <label for="image2">Additional Image 2:</label>
                    <input type="file" id="image2" name="image2" class="form-control-file">
                    <img src="uploads/<?php echo $product['image2']; ?>" alt="Current Image" style="width: 150px; height: auto;">
                </div>
                <div class="form-group">
                    <label for="image3">Additional Image 3:</label>
                    <input type="file" id="image3" name="image3" class="form-control-file">
                    <img src="uploads/<?php echo $product['image3']; ?>" alt="Current Image" style="width: 150px; height: auto;">
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>   

    </body>

</html>
