<?php
// Include database connection
include('db.php');

// Get the email from the request
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';

// Prepare a response
$response = ['registered' => false];

if (!empty($email)) {
    // Check if the email exists in the 'cust_registration' table
    $query = "SELECT * FROM cust_registration WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email found, the user is registered
        $response['registered'] = true;
    }
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
