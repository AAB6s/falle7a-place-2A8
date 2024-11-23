<?php
require_once __DIR__ .'/../../Controller/produitC.php';

if (isset($_GET['Id_Produit']) && is_numeric($_GET['Id_Produit'])) {
    $produitC = new ProduitC();
    $produitC->deleteProduct($_GET['Id_Produit']); 
    header('Location: ListProduitBack.php');
    exit(); 
} else {
    echo "Invalid or missing Product ID.";
}

?>
