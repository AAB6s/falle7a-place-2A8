    <?php
    session_start();  // Start the session at the beginning

    require_once '../controller/UserController.php';
    require_once '../model/User.php';
    require_once '../config.php';
    require_once '../vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        header('Content-Type: application/json');

        $username = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];

        $user = new User($username, $email, $password, $address);

        $_SESSION['temp_user'] = serialize($user);

        $verificationCode = random_int(100000, 999999);

        try {
            $mail = new PHPMailer(true);
            configureMailer($mail);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your Verification Code';
            $mail->Body = "Your verification code is: <strong>$verificationCode</strong>";

            $mail->send();

            $_SESSION['verification_code'] = $verificationCode;

            echo json_encode(['status' => 'success', 'message' => 'User created successfully. Verification code sent.']);

            header('Location: verify.php?email=' . urlencode($email));
            exit;
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Failed to send verification code.']);
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="./styles/style.css">
    </head>
    <body>
        <div class="form-container">
            <div class="form-box register">
                <h2>Sign Up</h2>
                <form id="signupForm" method="POST" >
                    <div class="input-box">
                        <input type="text" id="name" name="name" placeholder="Username" autocomplete="new-username">
                        <i class="fas fa-user"></i>
                        <div id="nameError" class="error-message"></div> <!-- Error message will appear here -->
                    </div>
                    <div class="input-box">
                        <input type="email" id="signupEmail" name="email" placeholder="Email" autocomplete="new-email">
                        <i class="fas fa-envelope"></i>
                        <div id="emailError" class="error-message"></div> <!-- Error message will appear here -->
                    </div>
                    <div class="input-box">
                        <input type="password" id="signupPassword" name="password" placeholder="Password" autocomplete="new-password">
                        <i class="fas fa-lock"></i>
                        <i class="fas fa-eye" id="togglePassword" onclick="togglePassword()"></i> <!-- Eye icon to toggle visibility -->
                        <div id="passwordError" class="error-message"></div>
                    </div>
                    
                    <div class="input-box">
                        <input type="text" id="address" name="address" placeholder="Address" autocomplete="off">
                        <i class="fas fa-map-marker-alt"></i>
                        <div id="addressError" class="error-message"></div> <!-- Error message will appear here -->
                    </div>
                    <button type="submit">Sign Up</button>
                    <div class="logreg-link">
                        <p>Already have an account? <a href="signin.php">Sign In</a></p>
                    </div>
                </form>            
            </div>
        </div>
        <script src="./js/app.js"></script>
        <script>
            document.getElementById('signupForm').addEventListener('submit', function (e) {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('signupEmail').value.trim();
        const password = document.getElementById('signupPassword').value.trim();
        const address = document.getElementById('address').value.trim();

        let hasError = false;

        if (name.length < 3) {
            document.getElementById('nameError').textContent = 'Name must be at least 3 characters long.';
            hasError = true;
        } else {
            document.getElementById('nameError').textContent = '';
        }

        if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            document.getElementById('emailError').textContent = 'Enter a valid email.';
            hasError = true;
        } else {
            document.getElementById('emailError').textContent = '';
        }

        if (password.length < 6) {
            document.getElementById('passwordError').textContent = 'Password must be at least 6 characters.';
            hasError = true;
        } else {
            document.getElementById('passwordError').textContent = '';
        }

        if (address.length === 0) {
            document.getElementById('addressError').textContent = 'Address cannot be empty.';
            hasError = true;
        } else {
            document.getElementById('addressError').textContent = '';
        }

        if (hasError) {
            e.preventDefault();
        }
    });

        </script>
    </body>
    </html>
