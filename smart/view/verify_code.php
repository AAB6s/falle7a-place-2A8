<?php
require_once '../controller/UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);
    $email = filter_var($input['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $code = $input['code'] ?? '';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($code)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
        exit;
    }

    try {
        $userController = new UserController();
        $isValid = $userController->validateVerificationCode($email, $code);

        if ($isValid) {
            echo json_encode(['status' => 'success', 'message' => 'Verification code is valid.', 'redirect' => "update_password.php?email=$email"]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid verification code.']);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Verification failed.']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-box verify-code">
            <h2>Verify Code</h2>
            <form id="verifyCodeForm" autocomplete="off">
                <input type="hidden" id="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">
                <div class="input-box">
                    <input type="text" id="verificationCode" name="code" placeholder="Verification Code" required>
                    <i class="fas fa-check"></i>
                </div>
                <button type="submit" class="submit-btn">Verify Code</button>
                <div id="codeError" class="error-message"></div>
            </form>
        </div>
    </div>
    <script>
    document.getElementById('verifyCodeForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const email = document.getElementById('email').value.trim();
        const code = document.getElementById('verificationCode').value.trim();
        const codeError = document.getElementById('codeError');
        codeError.textContent = '';

        try {
            const response = await fetch('verify_code.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, code }),
            });

            const result = await response.json();

            if (result.status === 'success') {
                alert(result.message);
                window.location.href = result.redirect;
            } else {
                codeError.textContent = result.message || 'Invalid verification code.';
            }
        } catch (error) {
            codeError.textContent = 'An unexpected error occurred.';
        }
    });
    </script>
</body>
</html>