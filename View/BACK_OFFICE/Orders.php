<?php
require_once __DIR__ . '/../../Config.php';

try {
    $pdo = Config::getConnexion();

    // Fetch filter values
    $search = $_GET['search'] ?? '';
    $statusFilter = $_GET['status_filter'] ?? 'all';

    // Build the query dynamically based on filters
    $query = "SELECT * FROM transaction WHERE 1=1";
    if (!empty($search)) {
        $query .= " AND full_name LIKE :search";
    }
    if ($statusFilter !== 'all') {
        $query .= " AND status = :status";
    }
    $stmt = $pdo->prepare($query);

    // Bind parameters
    if (!empty($search)) {
        $stmt->bindValue(':search', '%' . $search . '%');
    }
    if ($statusFilter !== 'all') {
        $stmt->bindValue(':status', $statusFilter);
    }

    $stmt->execute();
    $transaction = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error fetching transaction: " . $e->getMessage());
}

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transaction_id'], $_POST['action'])) {
    $transactionId = $_POST['transaction_id'];
    $action = $_POST['action'];

    if ($action === 'deliver') {
        $status = 'delivered';
    } elseif ($action === 'cancel') {
        $status = 'canceled';
    }

    $query = "UPDATE transaction SET status = :status WHERE transaction_id = :transaction_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':status' => $status,
        ':transaction_id' => $transactionId
    ]);

    // Refresh the page to show updated data
    header('Location: Orders.php');
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css" />
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css" />
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css" />
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller" id="crud_service">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="#">
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
                                <img class="img-xs rounded-circle" src="assets/images/faces/face15.jpg" alt="" />
                                <span class="count bg-success"></span>
                            </div>
                            <div class="profile-name">
                                <h5 class="mb-0 font-weight-normal">Henry Klein</h5>
                                <span>Admin</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item nav-category">
                    <span class="nav-link">Navigation</span>
                </li>

                <!-- User Management -->
                <li class="nav-item menu-items">
                    <a class="nav-link" href="#">
                        <span class="menu-icon">
                            <i class="mdi mdi-account-multiple"></i>
                        </span>
                        <span class="menu-title">User Management</span>
                    </a>
                </li>

                <!-- Worker Management -->
                <li class="nav-item menu-items">
                    <a class="nav-link" href="#">
                        <span class="menu-icon">
                            <i class="mdi mdi-account-settings"></i>
                        </span>
                        <span class="menu-title">Worker Management</span>
                    </a>
                </li>

                <!-- Product Management -->
                <li class="nav-item menu-items">
                    <a class="nav-link" href="#">
                        <span class="menu-icon">
                            <i class="mdi mdi-package-variant"></i>
                        </span>
                        <span class="menu-title">Product Management</span>
                    </a>
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
                                <a class="nav-link" href="#">Service Analytics</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#crud_service">View Services (CRUD)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#request_service">Manage Service Requests</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Order Management -->
          <li class="nav-item menu-items">
            <a
              class="nav-link"
              data-toggle="collapse"
              href="#order-management"
              aria-expanded="false"
              aria-controls="order-management"
            >
              <span class="menu-icon">
                <i class="mdi mdi-cart"></i>
              </span>
              <span class="menu-title">Order Management</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="order-management">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="#">Transaction Manager</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Manage Orders</a>
                </li>
              </ul>
            </div>
          </li>
          <!-- Worker Management -->
        </nav>
        <!-- partial -->

        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg"
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
                                <input type="text" class="form-control" placeholder="Search products" />
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
                                        <p class="preview-subject ellipsis mb-1">
                                            Software Development
                                        </p>
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
                                        <p class="preview-subject ellipsis mb-1">
                                            UI Development
                                        </p>
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
                                        <p class="preview-subject ellipsis mb-1">
                                            Software Testing
                                        </p>
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
                                            class="rounded-circle profile-pic" />
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">
                                            Mark send you a message
                                        </p>
                                        <p class="text-muted mb-0">1 Minutes ago</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="assets/images/faces/face2.jpg" alt="image"
                                            class="rounded-circle profile-pic" />
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">
                                            Cregh send you a message
                                        </p>
                                        <p class="text-muted mb-0">15 Minutes ago</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="assets/images/faces/face3.jpg" alt="image"
                                            class="rounded-circle profile-pic" />
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">
                                            Profile picture updated
                                        </p>
                                        <p class="text-muted mb-0">18 Minutes ago</p>
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
                                        <p class="text-muted ellipsis mb-0">
                                            Just a reminder that you have an event today
                                        </p>
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
                                        <p class="text-muted ellipsis mb-0">Update dashboard</p>
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
                                        <p class="text-muted ellipsis mb-0">New admin wow!</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <p class="p-3 mb-0 text-center">See all notifications</p>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle" src="assets/images/faces/face15.jpg" alt="" />
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name">
                                        Henry Klein
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
                <!-- Main Content Wrapper -->
                <div class="content-wrapper">
                <?php if (!isset($_GET['update_id'])) : ?>
                    <!-- ======= Service Management Section ======= -->
                    <div class="page-header">
                        <h3 class="page-title" style="color: white;">
                            Order Management
                        </h3>
                    </div>


                    <div class="container">
        <h1>Transaction Management</h1>

        <!-- Filter and Search Form -->
        <div class="form-inline">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search by full name" value="<?= htmlspecialchars($search); ?>"  style="flex: 2; padding: 10px; border: 1px solid #ced4da; border-radius: 8px; font-size: 1em; background-color: #ffffff; transition: box-shadow 0.3s ease;">
                <select name="status_filter" style="flex: 1; padding: 10px; border: 1px solid #ced4da; border-radius: 8px; font-size: 1em; background-color: #ffffff; transition: box-shadow 0.3s ease;">
                    <option value="all" <?= $statusFilter === 'all' ? 'selected' : ''; ?>>All</option>
                    <option value="in progress" <?= $statusFilter === 'in progress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="delivered" <?= $statusFilter === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                    <option value="canceled" <?= $statusFilter === 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                </select>
                <button type="submit" class="btn-filter" style="flex: 0.5; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 8px; font-size: 1em; font-weight: bold; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s;">Filter</button>
            </form>
        </div>

        <!-- Display Transactions -->
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Order Status</h4>
                        <?php if (empty($transaction)) : ?>
                        <p>No transaction found.</p>
                        <?php else : ?>
                            <div class="table-responsive">
                                 <table style="color: white;"class="table table-bordered table-striped">
                                 <thead>
                                    <tr>
                                    <th>Transaction ID</th>
                                    <th>Action</th>
                                    <th>Full Name</th>
                                    <th>Phone Number</th>
                                    <th>Delivery Address</th>
                                    <th>Products Purchased</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($transaction as $transaction) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($transaction['transaction_id']); ?></td>
                                        <td>
                                            <form method="POST" action="Orders.php">
                                                <input type="hidden" name="transaction_id" value="<?= htmlspecialchars($transaction['transaction_id']); ?>">
                                                <button type="submit" name="action" value="deliver" class="btn btn-success">Send Delivery</button>
                                                <button type="submit" name="action" value="cancel" class="btn btn-danger">Cancel Delivery</button>
                                            </form>
                                        </td>

                                        <td><?= htmlspecialchars($transaction['full_name']); ?></td>
                                        <td><?= htmlspecialchars($transaction['phone_number']); ?></td>
                                        <td><?= htmlspecialchars($transaction['delivery_address']); ?></td>
                                        <td>
                                            <?php
                                            $products = json_decode($transaction['product_details'], true);
                                            if ($products) {
                                                echo "<ul style='margin: 0; padding-left: 15px;'>";
                                                foreach ($products as $product) {
                                                    echo "<li>" . htmlspecialchars($product['name']) . " - " .
                                                        htmlspecialchars($product['quantity']) . " pcs → " .
                                                        htmlspecialchars(number_format($product['price'])) . " TND</li>";
                                                }
                                                echo "</ul>";
                                            } else {
                                                echo "No products found.";
                                            }
                                            ?>
                                        </td>
                                        <td><div class="badge badge-outline-success"><?= htmlspecialchars($transaction['status']); ?></div></td>
                                        <td><?= htmlspecialchars($transaction['created_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
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
        <!-- End custom js for this page -->
    </div>
    <?php endif;?>
</body>