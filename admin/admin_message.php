<?php
// Start the session (if necessary)
session_start();

// Database connection
$servername = "localhost"; // Database server
$username = "root";        // Database username
$password = "";            // Database password
$dbname = "watchdemo"; // Database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit;
}
// Fetch all messages from the contact_messages table
$sql = "SELECT * FROM contact ORDER BY date_sent DESC";
$result = mysqli_query($conn, $sql);

// Check if any messages exist
if (mysqli_num_rows($result) > 0) {
    $messages = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $messages = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
</head>
<body>
<?php include('includes/header.php'); ?> 

    <header>
        <!-- Add your header content here -->
    </header>

    <section class="container mt-5">
        <h2>Contact Messages</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Sent On</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($messages)) : ?>
                    <?php foreach ($messages as $message) : ?>
                        <tr>
                            <td><?php echo $message['id']; ?></td>
                            <td><?php echo htmlspecialchars($message['name']); ?></td>
                            <td><?php echo htmlspecialchars($message['email']); ?></td>
                            <td><?php echo htmlspecialchars($message['subject']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                            <td><?php echo $message['date_sent']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">No messages found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <footer>
        <!-- Add your footer content here -->
    </footer>

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
</body>

</html>
