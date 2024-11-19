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

        if (!empty($_FILES["Image"]["tmp_name"])) {
            $targetDir = "uploads/";
            $imageName = basename($_FILES["Image"]["name"]);
            $targetFilePath = $targetDir . $imageName;
        
            $fileType = mime_content_type($_FILES["Image"]["tmp_name"]);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
            if (in_array($fileType, $allowedTypes)) {
                if (!empty($produit['Image']) && file_exists($produit['Image'])) {
                    unlink($produit['Image']);
                }
        
                if (move_uploaded_file($_FILES["Image"]["tmp_name"], $targetFilePath)) {
                    $Image = $targetFilePath; 
                } else {
                    $error = "Erreur lors du téléchargement de l'image.";
                    $Image = $produit['Image']; 
                }
            } else {
                $error = "Type de fichier non supporté. Veuillez uploader une image (jpeg, png, gif).";
                $Image = $produit['Image']; 
            }
        } else {
            $Image = $produit['Image']; 
        }
        

      
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
<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href="BACK_OFFICE/index.html"><img src="BACK_OFFICE/assets/images/logo.svg" alt="logo" /></a>
          <a class="sidebar-brand brand-logo-mini" href="BACK_OFFICE/index.html"><img src="BACK_OFFICE/assets/images/logo-mini.svg" alt="logo" /></a>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle " src="BACK_OFFICE/assets/images/faces/face15.jpg" alt="">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal">Henry Klein</h5>
                  <span>Admin</span>
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
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-onepassword  text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-calendar-today text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                  </div>
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="BACK_OFFICE/index.html">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-laptop"></i>
              </span>
              <span class="menu-title">Basic UI Elements</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="BACK_OFFICE/pages/ui-features/buttons.html">Buttons</a></li>
                <li class="nav-item"> <a class="nav-link" href="BACK_OFFICE/pages/ui-features/dropdowns.html">Dropdowns</a></li>
                <li class="nav-item"> <a class="nav-link" href="BACK_OFFICE/pages/ui-features/typography.html">Typography</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="BACK_OFFICE/pages/forms/basic_elements.html">
              <span class="menu-icon">
                <i class="mdi mdi-playlist-play"></i>
              </span>
              <span class="menu-title">Form Elements</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="BACK_OFFICE/pages/tables/basic-table.html">
              <span class="menu-icon">
                <i class="mdi mdi-table-large"></i>
              </span>
              <span class="menu-title">Tables</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="BACK_OFFICE/pages/charts/chartjs.html">
              <span class="menu-icon">
                <i class="mdi mdi-chart-bar"></i>
              </span>
              <span class="menu-title">Charts</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="BACK_OFFICE/pages/icons/mdi.html">
              <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
              </span>
              <span class="menu-title">Icons</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <span class="menu-icon">
                <i class="mdi mdi-security"></i>
              </span>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="BACK_OFFICE/pages/samples/blank-page.html"> Blank Page </a></li>
                <li class="nav-item"> <a class="nav-link" href="BACK_OFFICE/pages/samples/error-404.html"> 404 </a></li>
                <li class="nav-item"> <a class="nav-link" href="BACK_OFFICE/pages/samples/error-500.html"> 500 </a></li>
                <li class="nav-item"> <a class="nav-link" href="BACK_OFFICE/pages/samples/login.html"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="BACK_OFFICE/pages/samples/register.html"> Register </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="http://www.bootstrapdash.com/demo/corona-free/jquery/documentation/documentation.html">
              <span class="menu-icon">
                <i class="mdi mdi-file-document-box"></i>
              </span>
              <span class="menu-title">Documentation</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:BACK_OFFICE/partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="BACK_OFFICE/index.html"><img src="BACK_OFFICE/assets/images/logo-mini.svg" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav w-100">
              <li class="nav-item w-100">
                <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                  <input type="text" class="form-control" placeholder="Search produits">
                </form>
              </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown d-none d-lg-block">
                <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown" data-toggle="dropdown" aria-expanded="false" href="#">+ Create New Project</a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
                  <h6 class="p-3 mb-0">Projects</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-file-outline text-primary"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Software Development</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-web text-info"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">UI Development</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-layers text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Software Testing</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">See all projects</p>
                </div>
              </li>
              <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="#">
                  <i class="mdi mdi-view-grid"></i>
                </a>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-email"></i>
                  <span class="count bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                  <h6 class="p-3 mb-0">Messages</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="BACK_OFFICE/assets/images/faces/face4.jpg" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Mark send you a message</p>
                      <p class="text-muted mb-0"> 1 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="BACK_OFFICE/assets/images/faces/face2.jpg" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
                      <p class="text-muted mb-0"> 15 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="BACK_OFFICE/assets/images/faces/face3.jpg" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Profile picture updated</p>
                      <p class="text-muted mb-0"> 18 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">4 new messages</p>
                </div>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                  <i class="mdi mdi-bell"></i>
                  <span class="count bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <h6 class="p-3 mb-0">Notifications</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-calendar text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Event today</p>
                      <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event today </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Settings</p>
                      <p class="text-muted ellipsis mb-0"> Update dashboard </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-link-variant text-warning"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Launch Admin</p>
                      <p class="text-muted ellipsis mb-0"> New admin wow! </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">See all notifications</p>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="BACK_OFFICE/assets/images/faces/face15.jpg" alt="">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name">Henry Klein</p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Profile</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Settings</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Log out</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">Advanced settings</p>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
          <!-- partial -->
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
        <input type="text" class="form-control" id="Nom" name="Nom" value="<?php echo htmlspecialchars($produit['Nom']); ?>">
    </div>
    <div class="form-group">
        <label for="Image">Image</label>
        <input type="file" class="form-control" id="Image" name="Image">

        
        <small>Image actuelle :<img class="img-fluid"
                     src="data:image/jpeg;base64,<?php echo base64_encode($produit['Image']); ?>" 
                   ></small>
    </div>
    <div class="form-group">
        <label for="Description">Description</label>
        <textarea class="form-control" id="Description" name="Description" rows="4"><?php echo htmlspecialchars($produit['Description']); ?></textarea>
    </div>
    <div class="form-group">
        <label for="Prix">Prix</label>
        <input type="number" class="form-control" id="Prix" name="Prix" value="<?php echo htmlspecialchars($produit['Prix']); ?>">
    </div>
    <div class="form-group">
        <label for="Quantite">Quantité</label>
        <input type="number" class="form-control" id="Quantite" name="Quantite" value="<?php echo htmlspecialchars($produit['Quantite']); ?>">
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector(".forms-sample");

        form.addEventListener("submit", function (event) {
            let isValid = true;

            // Réinitialisation des messages d'erreur
            form.querySelectorAll(".error-message").forEach((msg) => msg.remove());
            form.querySelectorAll("input, textarea").forEach((input) => {
                input.classList.remove("error", "success");
            });

            // Validation du champ "Nom"
            const nom = form.querySelector("input[name='Nom']");
            if (nom.value.trim() === "") {
                isValid = false;
                showMessage(nom, "Le champ Nom ne peut pas être vide.", false);
            } else {
                showMessage(nom, "Nom valide.", true);
            }

            // Validation du champ "Image"
            const image = form.querySelector("input[name='Image']");
            if (image.value && !/\.(jpg|jpeg|png|gif)$/i.test(image.value)) {
                isValid = false;
                showMessage(image, "Le champ Image doit être un fichier valide (jpg, jpeg, png, gif).", false);
            } else if (image.value) {
                showMessage(image, "Image valide.", true);
            }

            // Validation du champ "Description"
            const description = form.querySelector("textarea[name='Description']");
            if (description.value.trim() === "") {
                isValid = false;
                showMessage(description, "Le champ Description ne peut pas être vide.", false);
            } else {
                showMessage(description, "Description valide.", true);
            }

            // Validation du champ "Prix"
            const prix = form.querySelector("input[name='Prix']");
            if (prix.value <= 0) {
                isValid = false;
                showMessage(prix, "Le champ Prix doit être supérieur à 0.", false);
            } else {
                showMessage(prix, "Prix valide.", true);
            }

            // Validation du champ "Quantité"
            const quantite = form.querySelector("input[name='Quantite']");
            if (quantite.value <= 0 || !Number.isInteger(parseFloat(quantite.value))) {
                isValid = false;
                showMessage(quantite, "Le champ Quantité doit être un entier positif.", false);
            } else {
                showMessage(quantite, "Quantité valide.", true);
            }

            // Empêche l'envoi du formulaire si des erreurs sont détectées
            if (!isValid) {
                event.preventDefault();
            }
        });

        function showMessage(input, message, isSuccess) {
            const messageElement = document.createElement("span");
            messageElement.textContent = message;
            messageElement.classList.add("error-message");
            messageElement.style.color = isSuccess ? "green" : "red";
            input.classList.add(isSuccess ? "success" : "error");
            input.insertAdjacentElement("afterend", messageElement);
        }
    });
</script>

<style>
    .error {
        border-color: red;
    }

    .success {
        border-color: green;
    }

    .error-message {
        font-size: 0.9rem;
        margin-left: 5px;
    }
</style>

<script src="BACK_OFFICE/assets/vendors/js/vendor.bundle.base.js"></script>
<script src="BACK_OFFICE/assets/js/off-canvas.js"></script>
<script src="BACK_OFFICE/assets/js/misc.js"></script>
</body>
</html>
