<?php
include '../Controller/ProduitC.php';
include_once '../Model/Produit.php';

$error = "";
$produitC = new ProduitC();

if (isset($_GET['Id_Produit'])) {
    $Id_Produit = intval($_GET['Id_Produit']);
    $produit = $produitC->getProduitById($Id_Produit);
    if (!$produit) {
        $error = "Produit non trouvé.";
    }
}

if (
    isset($_POST["Nom"], $_POST["Description"], $_POST["Prix"], $_POST["Quantite"])
) {
    if (
        !empty($_POST["Nom"]) &&
        !empty($_POST["Description"]) &&
        !empty($_POST["Prix"]) &&
        !empty($_POST["Quantite"])
    ) {
        $Nom = $_POST['Nom'];
        $Description = $_POST['Description'];
        $Prix = floatval($_POST['Prix']);
        $Quantite = intval($_POST['Quantite']);

        // Gestion de l'image
        if (!empty($_FILES["Image"]["tmp_name"])) {
            $targetDir = "uploads/";
            $imageName = basename($_FILES["Image"]["name"]);
            $targetFilePath = $targetDir . $imageName;

            if (move_uploaded_file($_FILES["Image"]["tmp_name"], $targetFilePath)) {
                $Image = $targetFilePath;
            } else {
                $error = "Erreur lors du téléchargement de l'image.";
                $Image = $produit['Image']; // Conserver l'image existante
            }
        } else {
            $Image = $produit['Image']; // Conserver l'image existante si aucun nouveau fichier n'est fourni
        }

        // Mise à jour du produit
        $produitUpdated = new Produit($Id_Produit, $Image, $Nom, $Description, $Prix, $Quantite);
        $produitC->updateProduit($Id_Produit, $produitUpdated);

        // Redirection après mise à jour
        header('Location: ListProduitBack.php');
        exit();
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="wId_Produitth=device-wId_Produitth, initial-scale=1, shrink-to-fit=no">
    <title>Modifier Produit - Falle7a</title>
    <link rel="stylesheet" href="BACK_OFFICE/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="BACK_OFFICE/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="BACK_OFFICE/assets/css/style.css">
    <link rel="shortcut icon" href="BACK_OFFICE/assets/images/favicon.png">
</head>
<body>
<div class="container-scroller">
    <!-- Formulaire de modification -->
    <div class="col-md-6 grId_Produit-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Modifier Produit</h4>
                <div Id_Produit="error" style="color:red;">
                    <?php echo $error; ?>
                </div>
                <?php if ($produit): ?>
                <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="Nom">Nom du Produit</label>
                        <input type="text" class="form-control" Id_Produit="Nom" name="Nom" value="<?php echo $produit['Nom']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Image">Image</label>
                        <input type="file" class="form-control" Id_Produit="Image" name="Image">
                        <small>Image actuelle : <?php echo $produit['Image']; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="Description">Description</label>
                        <textarea class="form-control" Id_Produit="Description" name="Description" rows="4" required><?php echo $produit['Description']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Prix">Prix</label>
                        <input type="number" step="0.01" class="form-control" Id_Produit="Prix" name="Prix" value="<?php echo $produit['Prix']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Quantite">Quantité</label>
                        <input type="number" class="form-control" Id_Produit="Quantite" name="Quantite" value="<?php echo $produit['Quantite']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>
                <?php else: ?>
                    <p>Produit introuvable.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="BACK_OFFICE/assets/vendors/js/vendor.bundle.base.js"></script>
<script src="BACK_OFFICE/assets/js/off-canvas.js"></script>
<script src="BACK_OFFICE/assets/js/misc.js"></script>
</body>
</html>
