<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employes_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$message = ""; // Initialiser une variable pour le message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];

    $stmt = $conn->prepare("INSERT INTO employes (nom, prenom, email, telephone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom, $prenom, $email, $telephone);

    if ($stmt->execute()) {
        // Rediriger vers contact.html après succès
        header("Location: contact.html?success=1");
        exit();
    } else {
        $message = "Erreur : " . $stmt->error; // Afficher un message d'erreur
    }

    $stmt->close();
}

$conn->close();
?>