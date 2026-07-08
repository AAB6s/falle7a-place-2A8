<?php
include '../Controller/CategorieC.php';

if (isset($_GET["id_Categorie"])) {
    $id_Categorie = htmlspecialchars($_GET["id_Categorie"]); // Sécuriser l'ID de la catégorie
    $categorieC = new CategorieC();
    $categorieC->deleteCategorie($id_Categorie); // Appeler la méthode pour supprimer la catégorie

    // Rediriger vers la liste des catégories après suppression
    header('Location: ListeCategorieBack.php');
    exit(); // Toujours appeler exit() après header() pour arrêter l'exécution du script
} else {
    // Si l'ID de la catégorie n'est pas défini dans l'URL, afficher une erreur ou rediriger
    echo "Erreur: L'ID de la catégorie est manquant.";
    exit();
}
?>
