<?php
session_start();
header('Content-Type: application/json');

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$otp = $data['otp'] ?? '';
$new_password = $data['new_password'] ?? '';

$response = ['success' => false, 'message' => ''];

// Check for empty fields
if (empty($email) || empty($otp) || empty($new_password)) {
    $response['message'] = 'All fields are required.';
    echo json_encode($response);
    exit();
}

// Validate OTP and email
if ($_SESSION['email'] === $email && $_SESSION['otp'] == $otp) {
    include('db.php');

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Update the new password in the database
    $query = "UPDATE cust_registration SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ss", $hashed_password, $email);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Password reset successfully!';
        } else {
            $response['message'] = 'Error updating password. Please try again.';
        }
    } else {
        $response['message'] = 'Database query preparation failed.';
    }
} else {
    $response['message'] = 'Invalid OTP or email.';
}

echo json_encode($response);
?>
