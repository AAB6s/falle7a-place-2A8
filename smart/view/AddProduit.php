<?php
include '../Controller/produitC.php';
include '../Controller/categorieC.php';
include_once '../Model/produit.php';

$error = "";

// Instances des contrôleurs
$produitC = new ProduitC();
$categorieC = new CategorieC();

// Récupérer toutes les catégories pour les afficher dans le formulaire
$categories = $categorieC->getAllCategories();

$error = "";

if (
    isset($_POST["Nom"]) &&
    isset($_POST["Description"]) &&
    isset($_POST["Prix"]) &&
    isset($_POST["Quantite"]) &&
    isset($_FILES["Image"]) &&
    isset($_POST["id_Categorie"]) 
) {
    
    if (
        !empty($_POST["Nom"]) &&
        !empty($_POST["Description"]) &&
        !empty($_POST["Prix"]) &&
        !empty($_POST["Quantite"]) &&
        !empty($_FILES["Image"]["tmp_name"]) &&
        !empty($_POST["id_Categorie"])
    ) {
        // Récupérer et nettoyer les données
        $Nom = htmlspecialchars($_POST['Nom']);
        $Description = htmlspecialchars($_POST['Description']);
        $Prix = (float)$_POST['Prix'];
        $Quantite = (int)$_POST['Quantite'];
        $id_Categorie = (int)$_POST['id_Categorie'];

        
        $imageData = file_get_contents($_FILES["Image"]["tmp_name"]);

        
        $produit = new Produit(0, $imageData, $Nom, $Description, $Prix, $Quantite, $id_Categorie);

        // Ajouter le produit
        $produitC->addProduit($produit);

        // Rediriger vers la liste des produits
        header('Location: ListProduitBack.php');
        exit();
   
      } else {
        $error = "Please fill all the fields and upload an image.";
    }
} 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--  meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
    <script>
    if (!localStorage.getItem('token') || JSON.parse(atob(localStorage.getItem('token').split('.')[1])).data.role === 'user') window.location.href = "logout.php";
    </script>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="Back_Office/index.php">
                    <img src="assets/images/logo.svg" alt="logo" />
                </a>
                <a class="sidebar-brand brand-logo-mini" href="#">
                    <img src="assets/images/logo-mini.svg" alt="logo" />
                </a>
            </div>
            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img class="img-xs rounded-circle" id="profile-image"
                                    src="assets/images/faces/face15.jpg" alt="">
                                <span class="count bg-success"></span>
                            </div>
                            <div class="profile-name">
                                <h5 class="mb-0 font-weight-normal" id="profile-name">Henry Klein</h5>
                                <span>Gold Member</span>
                            </div>
                        </div>
                        <a href="#" id="profile-dropdown" data-toggle="dropdown"><i
                                class="mdi mdi-dots-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list"
                            aria-labelledby="profile-dropdown">
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
                                        <i class="mdi mdi-onepassword text-info"></i>
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
                <!-- User Management -->
                <li class="nav-item menu-items">
                    <a class="nav-link" href="userList.php">
                        <span class="menu-icon">
                            <i class="mdi mdi-account-multiple"></i>
                        </span>
                        <span class="menu-title">User Management</span>
                    </a>
                </li>
                <!-- Worker Management (with Sub-Menu) -->
                <li class="nav-item menu-items">
                    <a class="nav-link" data-toggle="collapse" href="#worker-management" aria-expanded="false"
                        aria-controls="worker-management">
                        <span class="menu-icon">
                            <i class="mdi mdi-account-settings"></i>
                        </span>
                        <span class="menu-title">Worker Management</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="worker-management">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'nav-linkactive' : ''; ?>"
                                    href="Back_Office/dashboard.php">
                                    Employees
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'reservationList.php') ? 'active' : ''; ?>"
                                    href="Back_Office/reservationList.php">
                                    Reservations
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Product Management (with Sub-Menu) -->
                <li class="nav-item menu-items">
                    <a class="nav-link" data-toggle="collapse" href="#product-management" aria-expanded="false"
                        aria-controls="product-management">
                        <span class="menu-icon">
                            <i class="mdi mdi-package-variant"></i>
                        </span>
                        <span class="menu-title">Product Management</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="product-management">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="AddCategorie.php">Add Categorie</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Add Product</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="ListProduitBack.php">List Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="ListeCategorieBack.php">List Categories</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Service Management (with Sub-Menu) -->
                <li class="nav-item menu-items">
                    <a class="nav-link" data-toggle="collapse" href="#service-management" aria-expanded="false"
                        aria-controls="service-management">
                        <span class="menu-icon">
                            <i class="mdi mdi-briefcase-check"></i>
                        </span>
                        <span class="menu-title">Service Management</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="service-management">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="Back_Office/service_page.php#view_service_type">Manage
                                    Service Types
                                    (CRUD)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Back_Office/service_page.php#view_service">View & Manage
                                    Services
                                    (CRUD)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Back_Office/service_request_page.php">Service Request
                                    Management</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Order Management -->
                <li class="nav-item menu-items">
                    <a class="nav-link" href="Back_Office/Orders.php">
                        <span class="menu-icon">
                            <i class="mdi mdi-cart"></i>
                        </span>
                        <span class="menu-title">Order Management</span>
                    </a>
                </li>
                <!-- Reclamation Management -->
                <li class="nav-item menu-items">
                    <a class="nav-link" href="Back_Office/afficher_reclamation.php">
                        <span class="menu-icon">
                            <i class="mdi mdi-alert-circle-outline"></i>
                        </span>
                        <span class="menu-title">View Reclamation</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="index.php"><img src="assets/images/logo-mini.svg"
                            alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav w-100">
                        <li class="nav-item w-100">
                            <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                                <input type="text" class="form-control" placeholder="Search products">
                            </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown d-none d-lg-block">
                            <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown"
                                data-toggle="dropdown" aria-expanded="false" href="#">+ Create New Project</a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="createbuttonDropdown">
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
                            <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-email"></i>
                                <span class="count bg-success"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="messageDropdown">
                                <h6 class="p-3 mb-0">Messages</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="assets/images/faces/face4.jpg" alt="image"
                                            class="rounded-circle profile-pic">
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1">Mark send you a message</p>
                                        <p class="text-muted mb-0"> 1 Minutes ago </p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="assets/images/faces/face2.jpg" alt="image"
                                            class="rounded-circle profile-pic">
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
                                        <p class="text-muted mb-0"> 15 Minutes ago </p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="assets/images/faces/face3.jpg" alt="image"
                                            class="rounded-circle profile-pic">
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
                            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                                data-toggle="dropdown">
                                <i class="mdi mdi-bell"></i>
                                <span class="count bg-danger"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="notificationDropdown">
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
                                        <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event
                                            today </p>
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
                                    <img class="img-xs rounded-circle" id="profileImage"
                                        src="assets/images/faces/face15.jpg" alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name" id="profileName">Henry
                                        Klein
                                    </p>
                                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="profileDropdown">
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
                                        <p class="preview-subject mb-1" onclick="logout()">Logout</p>
                                        <script>
                                        function logout() {
                                            window.location.href = "logout.php";
                                        }
                                        </script>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <p class="p-3 mb-0 text-center">Advanced settings</p>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> ajout du produit </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Forms</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Form</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">

                                <?php if (!empty($error)) : ?>
<div class="alert alert-danger">
    <?= $error; ?>
</div>
<?php endif; ?>

<form method="POST" action="" enctype="multipart/form-data" class="forms-sample">
    <div class="form-group">
        <label for="Nom">Nom du produit :</label>
        <input type="text" class="form-control" id="Nom" name="Nom" placeholder="Nom du produit">
    </div>

    <div class="form-group">
        <label for="Description">Description :</label>
        <textarea class="form-control" id="Description" name="Description" rows="3"
            placeholder="Description"></textarea>
    </div>

    <div class="form-group">
        <label for="Prix">Prix :</label>
        <input type="number" class="form-control" id="Prix" name="Prix" step="0.01" placeholder="Prix">
    </div>

    <div class="form-group">
        <label for="Quantite">Quantité :</label>
        <input type="number" class="form-control" id="Quantite" name="Quantite" placeholder="Quantité">
    </div>

    <div class="form-group">
        <label for="Image">Image :</label>
        <input type="file" class="form-control-file" id="Image" name="Image" accept="image/*">
    </div>

    <div class="form-group">
        <label for="id_Categorie">Catégorie :</label>
        <select class="form-control" id="id_Categorie" name="id_Categorie">
            <option value="">-- Sélectionner une catégorie --</option>
            <?php foreach ($categories as $categorie) : ?>
            <option value="<?= $categorie['Id_Categorie']; ?>"><?= $categorie['Nom']; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter</button>
    <a href="ListProduitBack.php" class="btn btn-secondary">Retour à la liste</a>
</form>

</div>
</div>
</div>

<!-- ======= Footer ======= -->
<footer class="footer">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
        <span class="text-muted text-center text-sm-left mb-2 mb-sm-0" style="color: white;">
            Copyright © Falle7a Place 2024
        </span>
        <span class="text-center text-sm-right" style="color: white;">
            Powered by
            <a href="#" target="_blank" class="text-success" style="color: white;">Falle7a
                Place</a>
        </span>
    </div>
</footer>
<!-- End Footer -->
</div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector(".forms-sample");

    form.addEventListener("submit", function(event) {
        let isValid = true;

        // Supprimer les anciens messages d'erreur
        form.querySelectorAll(".error-message").forEach((msg) => msg.remove());
        form.querySelectorAll("input, textarea, select").forEach((input) => {
            input.classList.remove("error", "success");
        });

        // Fonction pour afficher un message sous un champ
        function showMessage(input, message, isSuccess) {
            const parent = input.closest(".form-group");
            let messageElement = parent.querySelector(".error-message");

            // Créer le message d'erreur s'il n'existe pas
            if (!messageElement) {
                messageElement = document.createElement("small");
                messageElement.classList.add("error-message");
                parent.appendChild(messageElement);
            }

            // Mettre à jour le message et le style
            messageElement.textContent = message;
            messageElement.style.color = isSuccess ? "green" : "red";
            input.classList.add(isSuccess ? "success" : "error");
        }

        // Validation du champ Nom
        const nom = form.querySelector("input[name='Nom']");
        if (nom.value.trim() === "") {
            isValid = false;
            showMessage(nom, "Le champ Nom est obligatoire.", false);
        } else {
            showMessage(nom, "Nom valide.", true);
        }

        // Validation du champ Description
        const description = form.querySelector("textarea[name='Description']");
        if (description.value.trim() === "") {
            isValid = false;
            showMessage(description, "Le champ Description est obligatoire.", false);
        } else {
            showMessage(description, "Description valide.", true);
        }

        // Validation du champ Prix
        const prix = form.querySelector("input[name='Prix']");
        if (prix.value <= 0 || isNaN(prix.value)) {
            isValid = false;
            showMessage(prix, "Le champ Prix doit être un nombre positif.", false);
        } else {
            showMessage(prix, "Prix valide.", true);
        }

        // Validation du champ Quantité
        const quantite = form.querySelector("input[name='Quantite']");
        if (quantite.value <= 0 || !Number.isInteger(parseFloat(quantite.value))) {
            isValid = false;
            showMessage(quantite, "Le champ Quantité doit être un entier positif.", false);
        } else {
            showMessage(quantite, "Quantité valide.", true);
        }

        // Validation du champ Image
        const image = form.querySelector("input[name='Image']");
        if (image.files.length > 0) {
            const fileName = image.files[0].name;
            if (!/\.(jpg|jpeg|png|gif)$/i.test(fileName)) {
                isValid = false;
                showMessage(image,
                    "Le champ Image doit être un fichier valide (jpg, jpeg, png, gif).",
                    false);
            } else {
                showMessage(image, "Image valide.", true);
            }
        } else {
            isValid = false;
            showMessage(image, "Aucun fichier sélectionné.", false);
        }

        // Validation du champ Catégorie
        const categorie = form.querySelector("select[name='id_Categorie']");
        if (categorie.value === "") {
            isValid = false;
            showMessage(categorie, "Veuillez sélectionner une catégorie.", false);
        } else {
            showMessage(categorie, "Catégorie valide.", true);
        }

        // Bloquer la soumission du formulaire si non valide
        if (!isValid) {
            event.preventDefault();
        }
    });
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
    margin-top: 5px;
    display: block;
}
</style>
<!-- End custom js for this page -->
<!-- plugins:js -->
<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="assets/vendors/chart.js/Chart.min.js"></script>
<script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
<script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
<script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="assets/js/off-canvas.js"></script>
<script src="assets/js/hoverable-collapse.js"></script>
<script src="assets/js/misc.js"></script>
<script src="assets/js/settings.js"></script>
<script src="assets/js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="assets/js/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/build/jwt-decode.min.js"></script>
<script>
window.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('token');
    if (token) {
        try {
            const decodedToken = JSON.parse(atob(token.split('.')[1]));
            const userName = decodedToken.data.name;
            const userImage = decodedToken.data.image ||
                'assets/images/faces/face15.jpg';
            document.getElementById('profile-name').textContent = userName;
            document.getElementById('profile-image').src = userImage;
            document.getElementById('profileName').textContent = userName;
            document.getElementById('profileImage').src = userImage;
        } catch (error) {
            console.error('Error decoding the token:', error);
        }
    }
});
</script>
<!-- End custom js for this page -->
</body>

</html>