<?php

require_once '../models/EmployeModel.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employes_db";

$employeModel = new EmployeModel($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];

    $result = $employeModel->insertEmploye($nom, $prenom, $email, $telephone);

    if ($result === true) {
        // Rediriger vers un fichier de succès après succès
        header("Location: ../view/front/contact.html?success=1");
        exit();
    } else {
        echo "Erreur : " . $result; // Afficher un message d'erreur
    }
}

$employeModel->closeConnection();
?>