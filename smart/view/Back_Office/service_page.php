<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Added -->
    <link rel="shortcut icon" href="assets/images/favicon.png">
</head>

<body>
    <script>
    if (!localStorage.getItem('token') || JSON.parse(atob(localStorage.getItem('token').split('.')[1])).data
        .role === 'user') window.location.href = "../logout.php";
    </script>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="index.php">
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
                    <a class="nav-link" href="../../View/userList.php">
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
                                <a class="nav-link" href="dashboard.php">
                                    Employees
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="reservationList.php">
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
                                <a class="nav-link" href="../AddCategorie.php">Add Categorie</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../AddProduit.php">Add Product</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../ListProduitBack.php">List Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../ListeCategorieBack.php">List Categories</a>
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
                                <a class="nav-link" href="#view_service_type">Manage Service Types
                                    (CRUD)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#view_service">View & Manage Services
                                    (CRUD)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="service_request_page.php">Service Request Management</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Order Management -->
                <li class="nav-item menu-items">
                    <a class="nav-link" href="Orders.php">
                        <span class="menu-icon">
                            <i class="mdi mdi-cart"></i>
                        </span>
                        <span class="menu-title">Order Management</span>
                    </a>
                </li>
                <!-- Reclamation Management -->
                <li class="nav-item menu-items">
                    <a class="nav-link" href="afficher_reclamation.php">
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
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name" id="profileName">Henry Klein
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
                                            window.location.href = "../logout.php";
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
            <div class="main-panel" id="view_service_type">
                <div class="content-wrapper">

                    <!--Manage Service Types -->
                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Manage Service Types</h4>
                                    <p class="card-description">Manage different types of services available for users.
                                    </p>
                                    <!-- View Service Types -->
                                    <div class="form-container border p-4 mt-4" id="view_service_type_section">
                                        <h5 class="text-primary mb-3">View Service Types</h5>
                                        <div class="row" id="display_service_type">
                                            <!-- display_service_type with ajax -->
                                        </div>
                                    </div>
                                    <!-- Add Service Type -->
                                    <div class="form-container border p-4 mt-4" id="add_service_type_section">
                                        <h5 class="text-primary mb-3">Add a New Service Type</h5>
                                        <div class="text-white p-4 mt-4 rounded" style="background-color: #333;">
                                            <form id="addServiceTypeForm" method="GET" onsubmit="validateForm(event);">

                                                <div class="mb-3">
                                                    <label for="type_name" class="form-label text-warning">Type
                                                        Name</label>
                                                    <input type="text" id="type_name"
                                                        class="form-control text-white bg-transparent border-secondary">
                                                    <div id="type_name_error" class="text-danger mt-2 d-none">Type Name
                                                        is required.</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="short_description" class="form-label text-warning">Short
                                                        Description</label>
                                                    <textarea id="short_description"
                                                        class="form-control text-white bg-transparent border-secondary"
                                                        rows="3"></textarea>
                                                    <div id="short_description_error" class="text-danger mt-2 d-none">
                                                        Short Description is required.</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="icon" class="form-label text-warning">Icon</label>
                                                    <input type="text" id="icon"
                                                        placeholder="e.g., fa-tree or custom-url"
                                                        class="form-control text-white bg-transparent border-secondary">
                                                    <div id="icon_error" class="text-danger mt-2 d-none">Icon is
                                                        required.</div>
                                                    <a href="https://fontawesome.com/icons" target="_blank"
                                                        class="text-info d-block mt-2">View all available icons</a>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Add Service Type</button>
                                            </form>
                                            <p id="form_message" class="mt-3"></p>
                                        </div>
                                    </div>
                                    <!-- Update Service Type -->
                                    <div class="form-container border p-4 mt-4 d-none" id="update_service_type_section">
                                        <h5 class="text-primary mb-3">Update Service Type</h5>
                                        <div class="text-white p-4 mt-4 rounded" style="background-color: #333;">
                                            <form id="updateServiceTypeForm" method="GET"
                                                onsubmit="validateUpdateForm(event);">
                                                <input type="hidden" id="update_service_type_id">
                                                <div class="mb-3">
                                                    <label for="update_type_name" class="form-label text-warning">Type
                                                        Name</label>
                                                    <input type="text" id="update_type_name"
                                                        class="form-control text-white bg-transparent border-secondary">
                                                    <div id="update_type_name_error" class="text-danger mt-2 d-none">
                                                        Type Name is required.</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="update_short_description"
                                                        class="form-label text-warning">Short Description</label>
                                                    <textarea id="update_short_description"
                                                        class="form-control text-white bg-transparent border-secondary"
                                                        rows="3"></textarea>
                                                    <div id="update_short_description_error"
                                                        class="text-danger mt-2 d-none">Short Description is required.
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="update_icon"
                                                        class="form-label text-warning">Icon</label>
                                                    <input type="text" id="update_icon"
                                                        placeholder="e.g., fa-tree or custom-url"
                                                        class="form-control text-white bg-transparent border-secondary">
                                                    <div id="update_icon_error" class="text-danger mt-2 d-none">Icon is
                                                        required.</div>
                                                    <a href="https://fontawesome.com/icons" target="_blank"
                                                        class="text-info d-block mt-2">View all available icons</a>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update Service
                                                    Type</button>
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="toggleState()">Cancel</button>
                                            </form>
                                            <p id="update_form_message" class="mt-3"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Manage Services -->
                    <div class="row" id="view_service" style="padding-top:3%;">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Manage Services</h4>
                                    <p class="card-description">Manage standard services available for users.</p>

                                    <!-- Filter and View Services -->
                                    <div class="form-container border p-4 mt-4" id="view_service_section">
                                        <h5 class="text-primary mb-3">View Services</h5>
                                        <form id="service_filter_form" class="mb-3">
                                            <label for="service_filter_type" class="form-label text-warning">Filter by
                                                Service Type</label>
                                            <select id="filter_service_type"
                                                class="form-control text-white bg-transparent border-secondary"
                                                onchange="fetchAndDisplayServices(this.value)">
                                                <option value="">All Types</option>
                                                <!-- Options dynamically loaded via AJAX -->
                                            </select>
                                        </form>
                                        <div class="row" id="display_service">
                                            <!-- Services will be dynamically inserted here using AJAX -->
                                        </div>
                                    </div>

                                    <!-- Add Service -->
                                    <div class="form-container border p-4 mt-4" id="add_service_section">
                                        <h5 class="text-primary mb-3">Add a New Service</h5>
                                        <div class="text-white p-4 mt-4 rounded" style="background-color: #333;">
                                            <form id="add_service_form" method="POST"
                                                onsubmit="validateAddServiceForm(event);">
                                                <div class="mb-3">
                                                    <label for="service_name" class="form-label text-warning">Service
                                                        Name</label>
                                                    <input type="text" id="service_name"
                                                        class="form-control text-white bg-transparent border-secondary">
                                                    <div id="service_name_error" class="text-danger mt-2 d-none">Service
                                                        Name is required.
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="service_description"
                                                        class="form-label text-warning">Description</label>
                                                    <textarea id="service_description"
                                                        class="form-control text-white bg-transparent border-secondary"
                                                        rows="3"></textarea>
                                                    <div id="service_description_error" class="text-danger mt-2 d-none">
                                                        Description is required.
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="service_type" class="form-label text-warning">Service
                                                        Type</label>
                                                    <select id="service_type"
                                                        class="form-control text-white bg-transparent border-secondary">
                                                        <!-- Options dynamically loaded via AJAX -->
                                                    </select>
                                                    <div id="service_type_error" class="text-danger mt-2 d-none">Service
                                                        Type is required.
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Add Service</button>
                                            </form>
                                            <p id="add_service_message" class="mt-3"></p>
                                        </div>
                                    </div>

                                    <!-- Update Service -->
                                    <div class="form-container border p-4 mt-4 d-none" id="update_service_section">
                                        <h5 class="text-primary mb-3">Update Service</h5>
                                        <div class="text-white p-4 mt-4 rounded" style="background-color: #333;">
                                            <form id="update_service_form" method="POST"
                                                onsubmit="validateUpdateServiceForm(event);">
                                                <input type="hidden" id="update_service_id">
                                                <div class="mb-3">
                                                    <label for="update_service_name"
                                                        class="form-label text-warning">Service Name</label>
                                                    <input type="text" id="update_service_name"
                                                        class="form-control text-white bg-transparent border-secondary">
                                                    <div id="update_service_name_error" class="text-danger mt-2 d-none">
                                                        Service Name is
                                                        required.
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="update_service_description"
                                                        class="form-label text-warning">Description</label>
                                                    <textarea id="update_service_description"
                                                        class="form-control text-white bg-transparent border-secondary"
                                                        rows="3"></textarea>
                                                    <div id="update_service_description_error"
                                                        class="text-danger mt-2 d-none">Description is required.
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="update_service_type"
                                                        class="form-label text-warning">Service Type</label>
                                                    <select id="update_service_type"
                                                        class="form-control text-white bg-transparent border-secondary">
                                                        <!-- Options dynamically loaded via AJAX -->
                                                    </select>
                                                    <div id="update_service_type_error" class="text-danger mt-2 d-none">
                                                        Service Type is
                                                        required.
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update Service</button>
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="toggleServiceState()">Cancel</button>
                                            </form>
                                            <p id="update_service_message" class="mt-3"></p>
                                        </div>
                                    </div>
                                </div>
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
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
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
        <script src="assets/js/service.js"></script>
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