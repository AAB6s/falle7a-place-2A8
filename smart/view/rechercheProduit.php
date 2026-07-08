<?php
include '../Controller/ProduitC.php';
$produitC = new ProduitC();

// Récupération de la requête de recherche
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Recherche des produits en fonction de la requête
if ($searchQuery) {
    $results = $produitC->rechercherProduits($searchQuery);
    echo json_encode($results);
} else {
    echo json_encode([]);
}
?>
