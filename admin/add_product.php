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

// Check if the form is submitted
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
    
    // File upload handling
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // File upload handling
    $image = $_FILES['image']['name'];
    $image1 = $_FILES['image1']['name'];
    $image2 = $_FILES['image2']['name'];
    $image3 = $_FILES['image3']['name'];
    $target_dir = "uploads/";
    
    $upload_success = true;
    
    foreach (['image', 'image1', 'image2', 'image3'] as $img) {
        if ($_FILES[$img]['error'] !== UPLOAD_ERR_OK) {
            echo "<script>alert('Error uploading image: " . $_FILES[$img]['name'] . ". Error code: " . $_FILES[$img]['error'] . "'); window.location.href='add_product.php';</script>";
            $upload_success = false;
            break; // Stop processing if an error occurs
        }
        if (!move_uploaded_file($_FILES[$img]['tmp_name'], $target_dir . $_FILES[$img]['name'])) {
            echo "<script>alert('Error moving uploaded image: " . $_FILES[$img]['name'] . "'); window.location.href='add_product.php';</script>";
            $upload_success = false;
            break; // Stop processing if an error occurs
        }
    }
    
    // Check if the image is uploaded successfully
    if ($upload_success) {
        // Prepare SQL statement to insert product
        $sql = "INSERT INTO products (name, price, availability, brand, height, width, weight, color, manufacturer, description, image, image1, image2, image3) 
                VALUES ('$name', '$price', '$availability', '$brand', '$height', '$width', '$weight', '$color', '$manufacturer', '$description', '$image', '$image1', '$image2', '$image3')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Product added successfully!'); window.location.href='add_product.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href='add_product.php';</script>";
        }
    } $image = $_FILES['image']['name'];
    $image1 = $_FILES['image1']['name'];
    $image2 = $_FILES['image2']['name'];
    $image3 = $_FILES['image3']['name'];
    $target_dir = "admin/uploads/";

    $upload_success = true;

    foreach (['image','image1', 'image2', 'image3'] as $img) {
        if (!move_uploaded_file($_FILES[$img]['tmp_name'], $target_dir . $_FILES[$img]['name'])) {
            echo "<script>alert('Error uploading image: " . $_FILES[$img]['name'] . "'); window.location.href='add_product.php';</script>";
            $upload_success = false;
            break; // Stop processing if an error occurs
        }
    }
    move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image);
    move_uploaded_file($_FILES['image1']['tmp_name'], $target_dir . $image1);
    move_uploaded_file($_FILES['image2']['tmp_name'], $target_dir . $image2);
    move_uploaded_file($_FILES['image3']['tmp_name'], $target_dir . $image3);
    
    // Check if the image is uploaded successfully
    if ($upload_success) {
        // Prepare SQL statement to insert product
        $sql = "INSERT INTO products (name, price, availability, brand, height, width, weight, color, manufacturer, description, , image, image1, image2, image3) 
                VALUES ('$name', '$price', '$availability', '$brand', '$height', '$width', '$weight', '$color', '$manufacturer', '$description', '$image', '$image1', '$image2', '$image3')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Product added successfully!'); window.location.href='add_product.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href='add_product.php';</script>";
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <?php include('includes/head.php'); ?>
</head>
<body>
<?php include('includes/header.php'); ?>

   
    <!-- Start Banner Area -->
    

    <div class="content">
        <h2 class="mb-4">Add Products</h2>
    <!-- End Banner Area -->

    <!--================Add Product Area =================-->
    <div class="product_image_area">
        <div class="container">
            <div class="row s_product_inner">
                <div class="col-lg-12">
                    <h2 class="my-4 text-center">Add New Product</h2>
                    <form action="add_product.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Product Name:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" id="price" name="price" step="0.01" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="availability">Availability:</label>
                            <select id="availability" name="availability" class="form-control" required>
                                <option value="In Stock">In Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand:</label>
                            <input type="text" id="brand" name="brand" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="height">Height (cm):</label>
                            <input type="number" id="height" name="height" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="width">Width (cm):</label>
                            <input type="number" id="width" name="width" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight (g):</label>
                            <input type="number" id="weight" name="weight" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="color">Color:</label>
                            <input type="text" id="color" name="color" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="manufacturer">Manufacturer:</label>
                            <input type="text" id="manufacturer" name="manufacturer" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category">Category:</label>
                            <select id="category" name="category" class="form-control" required>
                                <option value="Smart Watch">Smart Watch</option>
                                <option value="Digital Watch">Digital Watch</option>
                                <option value="Analouge Watch">Analouge Watch</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="Men">Men</option>
                                <option value="Women">Women</option>
                            </select>
                        </div> 
                        <div class="form-group">
                            <label for="image">Product Image:</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                        </div>     
                        <div class="form-group">
                            <label for="image1">Product Image 1:</label>
                            <input type="file" id="image1" name="image1" class="form-control" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="image2">Product Image 2:</label>
                            <input type="file" id="image2" name="image2" class="form-control" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="image3">Product Image 3:</label>
                            <input type="file" id="image3" name="image3" class="form-control" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-success">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--================End Add Product Area =================-->

    <!-- Start Footer Area -->
    
    <!-- End Footer Area -->

    <?php include('includes/footer.php'); ?>   
</body>

</html>