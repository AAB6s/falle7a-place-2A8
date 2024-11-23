<?php
include '../Controller/categorieC.php';
include_once '../Model/Categorie.php';

$error = "";

$rep = null;

$categorieC = new CategorieC();
$list_Id_produit = $categorieC->AfficherId_produit();

if (isset($_POST["Id_produit"]) && isset($_POST["Nom"])) {
    if (!empty($_POST["Id_produit"]) && !empty($_POST["Nom"])) {
        $rep = new Categorie(
            $_POST['Id_produit'],
            $_POST['Nom']
        );
        $categorieC->AddCategorie($rep);
        header('Location: ListeCategorieBack.php');
        exit();  
    } else {
        $error = "Missing information";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Catégorie</title>
</head>
<body>
    <h2>Ajouter une Catégorie</h2>

    <!-- Affichage des erreurs -->
    <?php if (!empty($error)): ?>
        <div style="color: red;">
            <p><?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <!-- Formulaire d'ajout de catégorie -->
    <form action="AddCategorie.php" method="POST">
        <label for="Nom">Nom de la Catégorie :</label>
        <input type="text" name="Nom" id="Nom" required><br><br>

        <label for="Id_produit">ID du Produit :</label>
        <input type="number" name="Id_produit" id="Id_produit" required><br><br>

        <input type="submit" value="Ajouter la Catégorie">
    </form>

</body>
</html>
