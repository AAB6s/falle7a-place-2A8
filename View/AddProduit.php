<?php
include '../Controller/produitC.php';
include_once '../Model/produit.php';

$error = "";

// Create product instance
$produit = null;

// Create an instance of the controller
$produitC = new ProduitC();

if (
    isset($_POST["Nom"]) &&
    isset($_POST["Description"]) &&
    isset($_POST["Prix"]) &&
    isset($_POST["Quantite"]) &&
    isset($_POST["Image"]) // Added image field here
) {
    if (
        !empty($_POST["Nom"]) &&
        !empty($_POST["Description"]) &&
        !empty($_POST["Prix"]) &&
        !empty($_POST["Quantite"]) &&
        !empty($_POST["Image"]) // Ensure image string is provided
    ) {
        // Collect form data
        $Nom = $_POST['Nom'];
        $Description = $_POST['Description'];
        $Prix = $_POST['Prix'];
        $Quantite = $_POST['Quantite'];
        $Image = $_POST['Image']; // Get the image string (URL or base64)

        // Create product instance and add to the database
        $produit = new Produit(0, $Image, $Nom, $Description, $Prix, $Quantite);
        $produitC->addProduit($produit);

        // Redirect to the product list page
        header('Location: ListeProduits.php');
        exit();
    } else {
        $error = "Please fill all fields.";
    }
}
?>

<!-- HTML Form for product submission -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="BACK_OFFICE/assets/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container-scroller">
      <!-- partial:../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle " src="../../assets/images/faces/face15.jpg" alt="">
                  <span class="count bg-success"></span>
                </div>
                
              </div>
              <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-primary"></i>
                    </div>
                  </div>
                  
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-onepassword  text-info"></i>
                    </div>
                  </div>
                  
                
              </div>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="../../pages/forms/basic_elements.html">
              <span class="menu-icon">
                <i class="mdi mdi-playlist-play"></i>
              </span>
              <span class="menu-title"> Product Form </span>
            </a>
          </li>
        </ul>
      </nav>
      <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Products Form  </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Forms</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Form </li>
                </ol>
              </nav>
            </div>
      
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Products Form</h4>

                <!-- Display error message if any -->
                <?php if (!empty($error)) { ?>
                    <div style="color: red;"><?php echo $error; ?></div>
                <?php } ?>

                <!-- Form to submit product details -->
                <form action="AddProduit.php" method="POST" enctype="multipart/form-data" class="forms-sample">
                    <div class="form-group">
                        <label for="Nom">Product Name</label>
                        <input type="text" class="form-control" id="Nom" name="Nom" placeholder="Product Name" required>
                    </div>
                    <div class="form-group">
                        <label for="Description">Description</label>
                        <textarea class="form-control" id="Description" name="Description" placeholder="Description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Prix">Price</label>
                        <input type="number" class="form-control" id="Prix" name="Prix" step="0.01" placeholder="Price" required>
                    </div>
                    <div class="form-group">
                        <label for="Quantite">Quantity</label>
                        <input type="number" class="form-control" id="Quantite" name="Quantite" placeholder="Quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="Image">Product Image (URL or Base64)</label>
                        <input type="text" class="form-control" id="Image" name="Image" placeholder="Enter image URL or base64 string" required>
                    </div>

                    <div class="form-check form-check-flat form-check-primary">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input"> Remember me
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Add Product</button>
                    <button type="reset" class="btn btn-dark">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS for functionality -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
