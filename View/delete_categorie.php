<?php
include '../Controller/CategorieC.php';
$categorieC = new CategorieC();
$categorieC->deleteCategorie($_GET["id_Categorie"]);
header('Location: ListeCategorieBack.php');
?>