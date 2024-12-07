<?php
include '../Controller/ProduitC.php';

// Vérification de la méthode POST et des données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Id_Produit']) && isset($_POST['rating'])) {
        $Id_Produit = (int)$_POST['Id_Produit'];  // Assurez-vous que l'ID est un entier
        $rating = (int)$_POST['rating'];          // Assurez-vous que la note est un entier valide

        // Affichage pour vérifier les données reçues
        echo "Id_Produit reçu : $Id_Produit, Rating reçu : $rating";

        // Créer une instance de ProduitC pour traiter la mise à jour de la note
        $produitC = new ProduitC();

        // Appel de la méthode pour insérer ou mettre à jour la note
        if ($produitC->updateRating($Id_Produit, $rating)) {
            echo "La note a été mise à jour avec succès.";
        } else {
            // Si la note n'existe pas, on l'insère
            if ($produitC->insertRating($Id_Produit, $rating)) {
                echo "La note a été insérée avec succès.";
            } else {
                echo "Erreur lors de la mise à jour ou de l'insertion de la note.";
            }
        }
    } else {
        echo 'Données manquantes.';
    }
}
?>
