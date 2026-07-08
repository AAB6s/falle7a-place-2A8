<?php
require_once '../../controller/EmployeController.php';

$message = '';
$employeController = new EmployeController();
$Employees = $employeController->getAllEmployes();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['employee_id'])) {
  $employeeId = $_POST['employee_id'];
  $action = $_POST['action'];

  if ($action === 'approve') {
      $employeController->approveEmployee($employeeId);
      $message = "Employee approved successfully.";
  } elseif ($action === 'deny') {
      $employeController->denyEmployee($employeeId);
      $message = "Employee denied successfully.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script>
    if (!localStorage.getItem('token') && JSON.parse(atob(localStorage.getItem('token').split('.')[1])).data
        .role === 'admin') window.location.href = "../logout.php";
    </script>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
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
    <style>
    .table-dark {
        color: #ffffff;
        background-color: #121212;
    }

    .table-hover tbody tr:hover {
        background-color: #1e1e1e;
    }

    thead {
        font-weight: bold;
        text-transform: uppercase;
    }

    .btn-success {
        background: linear-gradient(45deg, #2e7d32, #43a047);
        border: none;
    }

    .btn-success:hover {
        background: linear-gradient(45deg, #1b5e20, #388e3c);
    }

    .btn-danger {
        background: linear-gradient(45deg, #b71c1c, #d32f2f);
        border: none;
    }

    .btn-danger:hover {
        background: linear-gradient(45deg, #7f0000, #c62828);
    }
    </style>
    <style>
    .form-control::placeholder {
        color: #aaaaaa;
        opacity: 1;
    }

    .form-control:focus {
        background-color: #1e1e1e;
        border-color: #0d47a1;
        box-shadow: 0 0 0 0.2rem rgba(13, 71, 161, 0.5);
    }

    select.form-control {
        appearance: none;
    }
    </style>
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
                <a class="sidebar-brand brand-logo" href="index.php"><img src="assets/images/logo.svg" alt="logo" /></a>
                <a class="sidebar-brand brand-logo-mini" href="index.php"><img src="assets/images/logo-mini.svg"
                        alt="logo" /></a>
            </div>
            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img class="img-xs rounded-circle " src="assets/images/faces/face15.jpg" alt="">
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
                                <a class="nav-link" href="#">
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
                                <a class="nav-link" href="service_page.php#view_service_type">Manage Service Types
                                    (CRUD)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="service_page.php#view_service">View & Manage Services
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
                                    <img class="img-xs rounded-circle" src="assets/images/faces/face15.jpg" alt="">
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
                                        <p class="preview-subject mb-1">Log out</p>
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
                    <h1>Employees</h1>
                    <?php if (isset($message) && $message != ''): ?>
                    <div class="alert alert-success" role="alert">
                        <?= htmlspecialchars($message); ?>
                    </div>
                    <?php endif; ?>
                    <div class="row align-items-center mb-3">
                        <!-- Search Input -->
                        <div class="col-md-8">
                            <input type="text" id="searchInput" placeholder="Search for names..."
                                class="form-control shadow-sm"
                                style="background-color: #2c2c2c; color: #ffffff; border: 1px solid #444; border-radius: 5px;">
                        </div>

                        <!-- Status Filter Dropdown -->
                        <div class="col-md-4">
                            <select id="statusFilter" class="form-control shadow-sm"
                                style="background-color: #2c2c2c; color: #ffffff; border: 1px solid #444; border-radius: 5px;">
                                <option value="">All</option>
                                <option value="approved">Approved</option>
                                <option value="denied">Denied</option>
                            </select>
                        </div>
                    </div>


                    <?php if (!empty($Employees)) : ?>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle shadow-sm" id="employeeTable">
                            <thead class="text-white" style="background: rgba(0, 0, 139, 0.555);">
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Telephone</th>
                                    <th>Status</th>
                                    <th>Verified</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($Employees as $employee) : ?>
                                <tr class="align-middle" data-status="<?= htmlspecialchars($employee->getStatus()); ?>">
                                    <td><?= htmlspecialchars($employee->getId()) ?></td>
                                    <td><?= htmlspecialchars($employee->getNom() . ' ' . $employee->getPrenom()); ?>
                                    </td>
                                    <td><?= htmlspecialchars($employee->getEmail()); ?></td>
                                    <td><?= htmlspecialchars($employee->getTelephone()); ?></td>
                                    <td class="text-center"
                                        style="font-weight: 600; 
                       color: <?= $employee->getStatus() === 'approved' ? 'green' : ($employee->getStatus() === 'denied' ? 'red' : 'white'); ?>;">
                                        <?= htmlspecialchars($employee->getStatus()); ?>
                                    </td>
                                    <td class="text-center" color: <?= $employee->getIsVerified() ? 'green' : 'red'; ?>;
                                        padding: 10px; border-radius: 5px;">
                                        <?php if ($employee->getIsVerified()) : ?>
                                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="20"
                                            height="20" id="verified" class="icon glyph" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M21.6,9.84A4.57,4.57,0,0,1,21.18,9,4,4,0,0,1,21,8.07a4.21,4.21,0,0,0-.64-2.16,4.25,4.25,0,0,0-1.87-1.28,4.77,4.77,0,0,1-.85-.43A5.11,5.11,0,0,1,17,3.54a4.2,4.2,0,0,0-1.8-1.4A4.22,4.22,0,0,0,13,2.21a4.24,4.24,0,0,1-1.94,0,4.22,4.22,0,0,0-2.24-.07A4.2,4.2,0,0,0,7,3.54a5.11,5.11,0,0,1-.66.66,4.77,4.77,0,0,1-.85.43A4.25,4.25,0,0,0,3.61,5.91,4.21,4.21,0,0,0,3,8.07,4,4,0,0,1,2.82,9a4.57,4.57,0,0,1-.42.82A4.3,4.3,0,0,0,1.63,12a4.3,4.3,0,0,0,.77,2.16,4,4,0,0,1,.42.82,4.11,4.11,0,0,1,.15.95,4.19,4.19,0,0,0,.64,2.16,4.25,4.25,0,0,0,1.87,1.28,4.77,4.77,0,0,1,.85.43,5.11,5.11,0,0,1,.66.66,4.12,4.12,0,0,0,1.8,1.4,3,3,0,0,0,.87.13A6.66,6.66,0,0,0,11,21.81a4,4,0,0,1,1.94,0,4.33,4.33,0,0,0,2.24.06,4.12,4.12,0,0,0,1.8-1.4,5.11,5.11,0,0,1,.66-.66,4.77,4.77,0,0,1,.85-.43,4.25,4.25,0,0,0,1.87-1.28A4.19,4.19,0,0,0,21,15.94a4.11,4.11,0,0,1,.15-.95,4.57,4.57,0,0,1,.42-.82A4.3,4.3,0,0,0,22.37,12,4.3,4.3,0,0,0,21.6,9.84Zm-4.89.87-5,5a1,1,0,0,1-1.42,0l-3-3a1,1,0,1,1,1.42-1.42L11,13.59l4.29-4.3a1,1,0,0,1,1.42,1.42Z"
                                                    style="fill:#04ff00"></path>
                                            </g>
                                        </svg>
                                        <?php else : ?>
                                        <svg fill="#ff0000" viewBox="0 0 32 32" version="1.1" width="20" height="20"
                                            xmlns="http://www.w3.org/2000/svg" stroke="#ff0000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <title>cancel</title>
                                                <path
                                                    d="M16 29c-7.18 0-13-5.82-13-13s5.82-13 13-13 13 5.82 13 13-5.82 13-13 13zM21.961 12.209c0.244-0.244 0.244-0.641 0-0.885l-1.328-1.327c-0.244-0.244-0.641-0.244-0.885 0l-3.761 3.761-3.761-3.761c-0.244-0.244-0.641-0.244-0.885 0l-1.328 1.327c-0.244 0.244-0.244 0.641 0 0.885l3.762 3.762-3.762 3.76c-0.244 0.244-0.244 0.641 0 0.885l1.328 1.328c0.244 0.244 0.641 0.244 0.885 0l3.761-3.762 3.761 3.762c0.244 0.244 0.641 0.244 0.885 0l1.328-1.328c0.244-0.244 0.244-0.641 0-0.885l-3.762-3.76 3.762-3.762z">
                                                </path>
                                            </g>
                                        </svg>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <form action="dashboard.php" method="POST" style="display:inline;"
                                            onsubmit="return confirm('Confirm Approve?')">
                                            <input type="hidden" name="employee_id"
                                                value="<?= htmlspecialchars($employee->getId()); ?>">
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit"
                                                class="btn btn-success btn-sm shadow-sm">Approve</button>
                                        </form>
                                        <form action="dashboard.php" method="POST" style="display:inline;"
                                            onsubmit="return confirm('Confirm Deny?')">
                                            <input type="hidden" name="employee_id"
                                                value="<?= htmlspecialchars($employee->getId()); ?>">
                                            <input type="hidden" name="action" value="deny">
                                            <button type="submit" class="btn btn-danger btn-sm shadow-sm">Deny</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                    <?php else : ?>
                    <p>No employees found.</p>
                    <?php endif; ?>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <!-- partial -->
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
    <script src="../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="../assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="../assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
</body>

<!-- container-scroller -->
<!-- plugins:js -->
<script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="../../assets/js/off-canvas.js"></script>
<script src="../../assets/js/hoverable-collapse.js"></script>
<script src="../../assets/js/misc.js"></script>
<script src="../../assets/js/settings.js"></script>
<script src="../../assets/js/todolist.js"></script>
<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#employeeTable tbody tr');
    rows.forEach(row => {
        const nameCell = row.cells[1].textContent
            .toLowerCase(); // Assuming name is in the second column
        row.style.display = nameCell.includes(searchValue) ? '' : 'none';
    });
});
document.getElementById('statusFilter').addEventListener('change', function() {
    const selectedStatus = this.value.toLowerCase(); // Get the selected value
    const rows = document.querySelectorAll('#employeeTable tbody tr'); // Select all rows in the table

    rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status')
            .toLowerCase(); // Get status from the data-status attribute

        if (selectedStatus === '' || rowStatus === selectedStatus) {
            row.style.display = ''; // Show the row
        } else {
            row.style.display = 'none'; // Hide the row
        }
    });
});
</script>
<script>
// Function to update the profile name and image in the dropdown
window.addEventListener('DOMContentLoaded', function() {
    const token = localStorage.getItem('token');
    if (token) {
        try {
            const decodedToken = JSON.parse(atob(token.split('.')[1]));
            const userName = decodedToken.data.name;
            const userImage = decodedToken.data.image ||
                'assets/images/faces/face15.jpg';
            document.getElementById('profile-name').textContent = userName;
            document.getElementById('profileName').textContent = userName;
        } catch (error) {
            console.error('Error decoding the token:', error);
        }
    }
});
</script>
<!-- endinject -->
</body>

</html>