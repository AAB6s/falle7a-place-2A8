<?php
// rateProduct.php

// Afficher les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id']) && isset($_POST['rating'])) {
        // Récupérer les données envoyées par la requête
        $productId = intval($_POST['product_id']);
        $rating = intval($_POST['rating']);

        // Vérification des valeurs reçues
        if ($rating >= 1 && $rating <= 5) {
            try {
                // Configuration de la connexion à la base de données
                $dsn = 'mysql:host=localhost;dbname=your_database;charset=utf8';
                $username = 'your_username';
                $password = 'your_password';

                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Préparer et exécuter la requête pour mettre à jour la note
                $stmt = $pdo->prepare('UPDATE produit SET rating = :rating WHERE id_Produit = :id');
                $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
                $stmt->bindParam(':id', $productId, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Note enregistrée avec succès.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Échec de la mise à jour dans la base de données.']);
                }
            } catch (PDOException $e) {
                // Gérer les erreurs SQL
                echo json_encode(['success' => false, 'message' => 'Erreur SQL : ' . $e->getMessage()]);
            }
        } else {
            // Note invalide
            echo json_encode(['success' => false, 'message' => 'La note doit être comprise entre 1 et 5.']);
        }
    } else {
        // Paramètres manquants
        echo json_encode(['success' => false, 'message' => 'Paramètres "product_id" et "rating" requis.']);
    }
} else {
    // Mauvaise méthode HTTP
    echo json_encode(['success' => false, 'message' => 'Méthode HTTP non autorisée.']);
}
?>
