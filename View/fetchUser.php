<?php
require_once '../controller/userController.php';

// Fetch users from the database
$userController = new userController();
$users = $userController->getUser();
?>