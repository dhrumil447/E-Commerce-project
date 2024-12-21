<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'db.php';
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

session_start();

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $query = "SELECT * FROM `cust_registration` WHERE email = '$email'";
    $sql = mysqli_query($conn, $query);
    $row = mysqli_num_rows($sql);

    if ($row > 0) {
        $otp = rand(100000, 999999);

        function sendOtp($email, $otp) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'watchvouge9@gmail.com';
                $mail->Password   = 'ckio aava yjxa gdxn'; // App password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                $mail->setFrom('watchvouge9@gmail.com', 'WatchVouge Store');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'WatchVouge Store';
                $mail->Body    =  "
                <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd;'>
                    <div style='background-color: #4CAF50; padding: 20px; text-align: center; color: white;'>
                        
                    <h1 style='margin: 0;'>WatchVouge Store</h1>
                        <p style='margin: 5px 0;'>Secure Your Account</p>
                    </div>
                    <div style='padding: 20px; text-align: center;'>
                        <h2 style='color: #333;'>Your OTP for Password Change</h2>
                        <p style='font-size: 22px; margin: 20px 0; color: #4CAF50; font-weight: bold;'>
                            $otp
                        </p>
                        <p style='color: #555; font-size: 16px;'>
                            Use this code to reset your password. If you didn't request this change, please ignore this email.
                        </p>
                        <p style='color: #888; font-size: 14px; margin-top: 20px;'>
                            This code will expire in 10 minutes.
                        </p>
                    </div>
                    <div style='text-align: center; padding: 15px; background-color: #f1f1f1; border-top: 1px solid #ddd;'>
                        <p style='font-size: 12px; color: #777;'>
                            Need help? Contact us at <a href='mailto:watchvouge9@gmail.com' style='color: #4CAF50;'>support@watchvouge.com</a>
                        </p>
                    </div>
                </div>";

                if ($mail->send()) {
                    $_SESSION['otp'] = $otp;
                    $_SESSION['email'] = $email;
                    header("location: ./otp.php");
                } else {
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        sendOtp($email, $otp);
    } else {
        header("location: ./forgetPassword.php?wrongEmailMsg=Your Email is Wrong!");
    }
} else if (isset($_POST['submit'])) {
    $inputOtp = $_POST['inputOtp'];
    $otp = $_SESSION['otp'];

    if ($inputOtp == $otp) {
        $_SESSION['inputOtp'] = $inputOtp;
        header("location: ./newPassword.php");
    } else {
        echo "<script>window.location.href = './otp.php?wrongOtp=Wrong OTP';</script>";
    }
} else if (isset($_POST['newPassword']) && isset($_POST['conformpassword'])) {
    $newpassword = $_POST['newPassword'];
    $conformpassword = $_POST['conformpassword'];
    $email = $_SESSION['email'];

    if (isset($_SESSION['inputOtp'])) {
        if (empty($newpassword) || empty($conformpassword)) {
            header("location: ./newPassword.php?emptyError=Empty Password");
        } else if ($newpassword === $conformpassword) {
            // Hash the new password before saving
            $hashedPassword = password_hash($newpassword, PASSWORD_BCRYPT);

            $update = "UPDATE `cust_registration` SET password = '$hashedPassword' WHERE email = '$email'";
            $query = mysqli_query($conn, $update);

            if ($query === true) {
                unset($_SESSION['inputOtp']);
                echo "
                <script>
                    alert('Password Changed Successfully');
                    window.location.href = './login.php?passwordChangeSuccess=Your password has been changed successfully!';
                </script>";
            } else {
                header("location: ./newPassword.php?updateError=Error updating password");
            }
        } else {
            header("location: ./newPassword.php?passwordError=Invalid Password");
        }
    } else {
        header("location: ./newPassword.php?redirectError=Something went wrong");
    }
} else if (isset($_POST['reGenerateOtp'])) {
    $email = $_SESSION['email'];
    $otp = rand(100000, 999999);

    function sendOtp($email, $otp) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'watchvouge9@gmail.com';
            $mail->Password   = 'ckio aava yjxa gdxn';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('watchvouge9@gmail.com', 'WatchVouge Store');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'WatchVouge Store';
            $mail->Body    =  "
            <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd;'>
                <div style='background-color: #4CAF50; padding: 20px; text-align: center; color: white;'>
                    <h1 style='margin: 0;'>WatchVouge Store</h1>
                    <p style='margin: 5px 0;'>Secure Your Account</p>
                </div>
                <div style='padding: 20px; text-align: center;'>
                    <h2 style='color: #333;'>Your OTP for Password Change</h2>
                    <p style='font-size: 22px; margin: 20px 0; color: #4CAF50; font-weight: bold;'>
                        $otp
                    </p>
                    <p style='color: #555; font-size: 16px;'>
                        Use this code to reset your password. If you didn't request this change, please ignore this email.
                    </p>
                    <p style='color: #888; font-size: 14px; margin-top: 20px;'>
                        This code will expire in 10 minutes.
                    </p>
                </div>
                <div style='text-align: center; padding: 15px; background-color: #f1f1f1; border-top: 1px solid #ddd;'>
                    <p style='font-size: 12px; color: #777;'>
                        Need help? Contact us at <a href='mailto:watchvouge9@gmail.com' style='color: #4CAF50;'>support@watchvouge.com</a>
                    </p>
                </div>
            </div>";

            if ($mail->send()) {
                $_SESSION['otp'] = $otp;
                header("location: ./otp.php");
            } else {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    sendOtp($email, $otp);
}
?>
