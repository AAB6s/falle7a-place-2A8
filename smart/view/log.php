<?php
require_once '../controller/UserController.php';
require_once '../config.php';
require_once '../vendor/autoload.php';

use Firebase\JWT\JWT;

$jwtSecretKey = JWT_SECRET;
$jwtAlgorithm = JWT_ALGORITHM;

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    $password = $data['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
        exit;
    }

    if (empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Password cannot be empty.']);
        exit;
    }

    $userController = new UserController();
    $user = $userController->loginUser($email, $password);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $payload = [
                'iss' => 'http://localhost/',
                'aud' => 'http://localhost/',
                'iat' => time(),
                'exp' => time() + 3600,
                'data' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                ],
            ];

            $jwt = JWT::encode($payload, $jwtSecretKey, $jwtAlgorithm);

            $redirectUrl = $user['role'] === 'admin' 
    ? 'http://localhost/smart/view/Back_Office/index.php' 
    : 'http://localhost/smart/view/Front_Office/index.html';

echo json_encode([
    'status' => 'success',
    'message' => 'Login successful',
    'token' => $jwt,
    'redirect_url' => $redirectUrl,
]);

        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
    }
}
?>
