<?php
include '../Controller/ProduitC.php';

if (isset($_GET['Id_Produit']) && is_numeric($_GET['Id_Produit'])) {
    $Id_Produit = intval($_GET['Id_Produit']); // Ensure the ID is an integer
    $produitC = new ProduitC();

    // Try to delete the product
    try {
        $deleted = $produitC->deleteProduct($Id_Produit);

        if ($deleted) {
            header('Location: ListProduitBack.php');
            exit();
        } else {
            echo "Product not found or could not be deleted.";
        }
    } catch (Exception $e) {
        // Handle any errors during the deletion process
        echo "Error: " . $e->getMessage();
    }
} else {
    // Provide feedback if the ID is invalid or missing
    echo "Invalid or missing Product ID.";
}
?>
