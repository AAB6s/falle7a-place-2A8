<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employes_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$id = $_POST['id'];
$status = $_POST['status'];

// Mettre à jour le statut de l'employé
$sql = "UPDATE employes SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    // Redirection pour rafraîchir la page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    echo "Erreur lors de la mise à jour du statut : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>