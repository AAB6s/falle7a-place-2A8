<?php
    require_once '../controller/userController.php';
    require_once '../model/user.php';

    $userController = new userController();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "Form submitted!";
        // Create a new User instance with the form data
        $user = new User($_POST['name'], $_POST['email'], $_POST['password'],$_POST['adress']);
        header('Location: userList.php');
        // Pass the User instance to addUser
        $userController->addUser($user);
    }
?>