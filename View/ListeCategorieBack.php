<?php
include '../Controller/categorieC.php';
include_once '../Model/Categorie.php';

$error = "";
$rep = null;

$categorieC = new CategorieC();
$list_Id_produit = $categorieC->AfficherId_produit();
$list_categories = $categorieC->AfficherCategories(); // Récupérer toutes les catégories

if (isset($_POST["Id_produit"]) && isset($_POST["Nom"])) {
    if (!empty($_POST["Id_produit"]) && !empty($_POST["Nom"])) {
        $rep = new Categorie(
            $_POST['Id_produit'],
            $_POST['Nom']
        );
        $categorieC->AddCategorie($rep);
        header('Location: AddCategorie.php'); // Redirection après ajout
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

    <!-- Affichage des catégories dans un tableau -->
    <h3>Liste des Catégories</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID Produit</th>
                <th>Nom de la Catégorie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list_categories as $categorie): ?>
                <tr>
                    <td><?php echo $categorie['Id_produit']; ?></td>
                    <td><?php echo $categorie['Nom']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
