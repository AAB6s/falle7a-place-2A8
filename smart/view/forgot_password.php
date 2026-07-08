<?php
require_once '../controller/UserController.php';
require_once '../config.php';
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);
    $email = filter_var($input['email'] ?? '', FILTER_SANITIZE_EMAIL);

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid or missing email address.']);
        exit;
    }

    try {
        $userController = new UserController();
        $verificationCode = random_int(100000, 999999);
        $isUserUpdated = $userController->setVerificationCode($email, $verificationCode);

        if ($isUserUpdated) {
            $mail = new PHPMailer(true);

            configureMailer($mail);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your Verification Code';
            $mail->Body = "Your verification code is: <strong>$verificationCode</strong>";

            $mail->send();

            echo json_encode(['status' => 'success', 'message' => 'Verification code sent successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Failed to send verification code.']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-box forgot-password">
            <h2>Forgot Password</h2>
            <form id="forgotPasswordForm" autocomplete="off">
                <div class="input-box">
                    <input type="email" id="forgotEmail" name="email" placeholder="Email" autocomplete="email" required>
                    <i class="fas fa-envelope"></i>
                    <div id="emailError" class="error-message"></div>
                </div>
                <button type="submit">Send Verification Code</button>
                <div class="logreg-link">
                    <p>Remembered your password? <a href="signin.php">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('forgotPasswordForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const email = document.getElementById('forgotEmail').value.trim();
        const emailError = document.getElementById('emailError');
        emailError.textContent = '';

        try {
            const response = await fetch('forgot_password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email }),
            });

            const result = await response.json();

            if (result.status === 'success') {
                alert(result.message);
                window.location.href = `verify_code.php?email=${encodeURIComponent(email)}`;
            } else {
                emailError.textContent = result.message || 'Failed to send verification code.';
            }
        } catch (error) {
            emailError.textContent = 'An unexpected error occurred. Please try again.';
        }
    });
    </script>
</body>
</html>

