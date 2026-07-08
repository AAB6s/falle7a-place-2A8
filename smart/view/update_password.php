<?php
require_once '../controller/UserController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);
    $email = filter_var($input['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $newPassword = $input['newPassword'] ?? '';
    $confirmPassword = $input['confirmPassword'] ?? '';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email address.']);
        exit;
    }
    if (empty($newPassword) || empty($confirmPassword)) {
        echo json_encode(['status' => 'error', 'message' => 'Password fields cannot be empty.']);
        exit;
    }
    if ($newPassword !== $confirmPassword) {
        echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
        exit;
    }

    try {
        $userController = new UserController();
        $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);
        $isUpdated = $userController->updatePassword($email, $newPasswordHash);

        if ($isUpdated) {
            echo json_encode(['status' => 'success', 'message' => 'Password updated successfully.', 'redirect' => 'signin.php']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update the password.']);
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred.']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-box update-password">
            <h2>Update Password</h2>
            <form id="updatePasswordForm" autocomplete="off">
                <input type="hidden" id="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">
                <div class="input-box">
                    <input type="password" id="newPassword" name="newPassword" placeholder="New Password" required>
                    <i class="fas fa-lock"></i>
                </div>
                <div class="input-box">
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                    <i class="fas fa-lock"></i>
                </div>
                <button type="submit" class="submit-btn">Update Password</button>
                <div id="updateError" class="error-message"></div>
            </form>
        </div>
    </div>
    <script>
    document.getElementById('updatePasswordForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const email = document.getElementById('email').value.trim();
        const newPassword = document.getElementById('newPassword').value.trim();
        const confirmPassword = document.getElementById('confirmPassword').value.trim();
        const updateError = document.getElementById('updateError');
        updateError.textContent = '';

        if (newPassword !== confirmPassword) {
            updateError.textContent = 'Passwords do not match.';
            return;
        }

        try {
            const response = await fetch('update_password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, newPassword, confirmPassword }),
            });

            const result = await response.json();

            if (result.status === 'success') {
                alert(result.message);
                window.location.href = result.redirect;
            } else {
                updateError.textContent = result.message || 'Failed to update password.';
            }
        } catch (error) {
            updateError.textContent = 'An unexpected error occurred. Please try again.';
        }
    });
    </script>
</body>
</html>
