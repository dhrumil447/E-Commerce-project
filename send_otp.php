<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';

$response = ['success' => false, 'message' => ''];

if (!empty($email)) {
    // Check if the email exists in the database (cust_registration table)
    include('db.php');
    $query = "SELECT * FROM cust_registration WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);

        // Store OTP in session for later validation
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Send OTP via PHPMailer
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration (set up your mail server details here)
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'watchvouge9@gmail.com'; // Your email
            $mail->Password = 'ckio aava yjxa gdxn'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Set the sender and recipient
            $mail->setFrom('watchvouge9@gmail.com', 'Your Company');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = 'Your OTP code is <b>' . $otp . '</b>. It will expire in 5 minutes.';

            $mail->send();
            $response['success'] = true;
            $response['message'] = 'OTP sent successfully!';
        } catch (Exception $e) {
            $response['message'] = 'Error: ' . $mail->ErrorInfo;
        }
    } else {
        $response['message'] = 'Email not registered.';
    }
} else {
    $response['message'] = 'Please provide a valid email.';
}

echo json_encode($response);
?>
