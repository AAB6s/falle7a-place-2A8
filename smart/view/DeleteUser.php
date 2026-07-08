<?php
require_once '../controller/userController.php';

// Check if 'id' is provided
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $userController = new userController();
    $userController->deleteUser($userId);
    // Redirect to the user list page
    header('Location: userList.php'); // Corrected syntax for header location
    exit;
} else {
    // Handle the case where 'id' is not provided
    echo "User ID not provided.";
}
?>
