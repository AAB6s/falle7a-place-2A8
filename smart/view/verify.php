<?php
require_once '../controller/UserController.php';
session_start();

// Check if the email and verification code are passed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $verificationCode = $_POST['verification_code'];

    $userController = new UserController();
    
    // Validate the verification code
    if (isset($_SESSION['verification_code']) && $_SESSION['verification_code'] == $verificationCode) {
        // Verification successful, insert the user into the database

        // Retrieve the user data from the session
        if (isset($_SESSION['temp_user'])) {
            $user = unserialize($_SESSION['temp_user']);
            
            // Insert the user into the database
            if ($userController->addUser($user)) {
                // After inserting the user, clear session data
                unset($_SESSION['temp_user']);
                unset($_SESSION['verification_code']);

                // Redirect to signin.php
                header('Location: signin.php');
                exit;
            } else {
                echo "Error occurred while creating the user.";
            }
        } else {
            echo "No user data found.";
        }
    } else {
        echo "Invalid verification code.";
    }
} else {
    // Show the verification form if it's a GET request
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
    } else {
        echo "No email provided.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-box verify">
            <h2>Account Verification</h2>
            <form id="verifyForm" method="POST">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <div class="input-box">
                    <input type="text" name="verification_code" placeholder="Enter Verification Code" required>
                    <i class="fas fa-check"></i>
                </div>
                <button type="submit">Verify</button>
                <div id="error-message" class="error-message"></div>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('verifyForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        
        const email = document.querySelector('input[name="email"]').value.trim();
        const verificationCode = document.querySelector('input[name="verification_code"]').value.trim();
        const errorMessage = document.getElementById('error-message');

        errorMessage.textContent = ''; // Clear any previous error messages

        try {
            // Send the data using AJAX (Fetch API)
            const response = await fetch('verify.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    email: email,
                    verification_code: verificationCode
                })
            });

            const result = await response.text();

            // Check if the response contains "Invalid" text (error)
            if (result.includes("Invalid verification code.")) {
                errorMessage.textContent = "Invalid verification code.";
            } else {
                // Redirect to signin.php if success
                window.location.href = 'signin.php';
            }
        } catch (error) {
            errorMessage.textContent = 'An unexpected error occurred. Please try again.';
        }
    });
    </script>
</body>
</html>
