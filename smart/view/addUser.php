<?php
session_start();  // Start the session at the beginning

require_once '../controller/userController.php';
require_once '../model/user.php';

$userController = new UserController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecting form data
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    // Create a new User object
    $user = new User($username, $email, $password, $address);

    // Try to add the user
    if (!$userController->addUser($user)) {
        // If the email or username is already taken, show an error
        echo "Username or email already exists.";
    } else {
        // On successful user creation, log the user in by creating a session

        // Fetch the newly created user's information from the database
        $newUser = $userController->getUserByEmail($email); // You can adjust this to retrieve the user by ID or email
        
        // Start a session for the user
        session_regenerate_id(true); // Regenerate session ID for security

        // Store user information in the session
        $_SESSION['user_id'] = $newUser['id'];
        $_SESSION['user_name'] = $newUser['name'];
        $_SESSION['user_email'] = $newUser['email'];
        $_SESSION['user_role'] = $newUser['role'];  // Adjust role if necessary (e.g., 'user', 'admin')

        // Optionally, set a session cookie (by default, PHP does this automatically)
        setcookie(session_name(), session_id(), time() + (86400 * 30), "/");  // Cookie will last 30 days

        // Redirect to the dashboard or another page after successful signup
        header('Location: signin.php');
        exit;
    }
}
?>
