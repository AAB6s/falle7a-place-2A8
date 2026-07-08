<?php
// Include necessary files and initialize database connection
require_once __DIR__ . '/../../Controller/ReservationController.php';
require_once __DIR__ . '/../../Controller/EmployeController.php';

$employeeController = new EmployeController();
$reservationController = new ReservationController();
$reservationId = $_GET['id_reservation'] ?? null;

if ($reservationId) {
    // Find the reservation
    $reservation = $reservationController->findReservation($reservationId);

    if ($reservation) {
        // Find the employee associated with the reservation
        $employee = $employeeController->readEmploye($reservation->getIdEmploye());
    } else {
        echo "Reservation not found.";
        exit;
    }
} else {
    echo "No reservation ID provided.";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];


    if ($reservationController->deleteReservation($reservation_id)) {
        $message = 'Reservation deleted successfully!';
        header('reservationList.php');
        exit();
    } else {
        // Display an error message
        $message = 'Error: Could not delete the reservation.';
    }
}
?>

<head>
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
    body {
        background-color: #1a1a2e;
        /* Dark blue-gray background */
        color: #f0f0f0;
        /* Light text */
    }
    </style>
    <style>
    body {
        background-color: #121212;
        color: #ffffff;
        font-family: 'Arial', sans-serif;
    }

    .reservation-card {
        background-color: #1e1e1e;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.7);
        padding: 25px;
        margin: 20px auto;
        max-width: 700px;
        transition: all 0.3s ease-in-out;
    }

    .reservation-card:hover {
        transform: scale(1.02);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.9);
    }

    .reservation-card h5 {
        font-weight: 700;
        color: #8f5fe8;
        text-transform: uppercase;
    }

    .reservation-card hr {
        border-color: #444444;
    }

    .details-item {
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        font-size: 0.95rem;
    }

    .details-item span {
        font-weight: 600;
        color: #bbbbbb;
    }

    .status {
        font-weight: 700;
        color: #28a745;
    }

    .btn-custom {
        font-weight: 600;
        border-radius: 8px;
        margin: 5px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-cancel {
        background-color: #dc3545;
        color: #ffffff;
        border: none;
    }

    .btn-cancel:hover {
        background-color: #c82333;
        box-shadow: 0 0 8px #dc3545;
    }

    .btn-print {
        background-color: transparent;
        color: #ffcc00;
        border: 1px solid #ffcc00;
    }

    .btn-print:hover {
        background-color: #ffcc00;
        color: #121212;
        box-shadow: 0 0 8px #ffcc00;
    }
    </style>
</head>

<body>
    <script>
    if (!localStorage.getItem('token') && JSON.parse(atob(localStorage.getItem('token').split('.')[1])).data
        .role === 'admin') window.location.href = "../logout.php";
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
                                <h5 class="mb-0 font-weight-normal">Henry Klein</h5>
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
                <li class="nav-item menu-items">
                    <a href="dashboard.php"
                        class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
                        <span class="menu-icon">
                            <i class="mdi mdi-laptop"></i>
                        </span>
                        <span class="menu-title">Employees</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a href="reservationList.php"
                        class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'reservationList.php') ? 'active' : ''; ?>">
                        <span class="menu-icon">
                            <i class="mdi mdi-laptop"></i>
                        </span>
                        <span class="menu-title">Reservations</span>
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
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name">Henry Klein</p>
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
                <a href="reservationList.php" class="btn btn-secondary">Back</a>

                <div class="container mt-5">
                    <!-- Dark Reservation Card -->
                    <div class="reservation-card">
                        <h5>Approved employee reservation </h5>
                        <hr>
                        <!-- Reservation Details -->
                        <div>
                            <div class="details-item">
                                <span>Status:</span> <span class="status">Confirmed</span>
                            </div>
                            <div class="details-item">
                                <span>Reservation Id:</span>
                                <span><?php echo $reservation->getIdReservation(); ?></span>
                            </div>
                            <div class="details-item">
                                <span>Employee Id:</span> <span><?php echo $reservation->getIdEmploye(); ?></span>
                            </div>
                            <div class="details-item">
                                <span>Entry:</span> <span><?php echo $reservation->getDebutReservation(); ?></span>
                            </div>
                            <div class="details-item">
                                <span>Exit:</span> <span><?php echo $reservation->getFinReservation(); ?></span>
                            </div>
                            <div class="details-item">
                                <span>Duration:</span> <span>17 days, 16 nights</span>
                            </div>
                        </div>
                        <hr>
                        <!-- Employee Details -->
                        <div>
                            <?php if ($employee): ?>
                            <h6 class="mb-3" style="color: #8f5fe8;">Employee Details</h6>
                            <div class="details-item">
                                <span>Name:</span> <span> <?php echo $employee->getNom()  ?></span>
                            </div>
                            <div class="details-item">
                                <span>Firstname:</span> <span> <?php echo $employee->getPrenom(); ?></span>
                            </div>
                            <div class="details-item">
                                <span>Email:</span> <span><?php echo $employee->getEmail(); ?></span>
                            </div>
                            <div class="details-item">
                                <span>Telephone:</span> <span><?php echo $employee->getTelephone(); ?></span>
                            </div>
                        </div>
                        <?php else: ?>
                        <p>Employee not found.</p>
                        <?php endif;?>
                        <!-- Buttons -->
                        <div class="mt-4 text-center">
                            <form method="POST" action="" class="d-inline"
                                onsubmit="confirm('Delete this reservation ? ')">
                                <input type="hidden" name="reservation_id"
                                    value="<?php echo htmlspecialchars($reservation->getIdReservation()); ?>">
                                <button type="submit" class="btn btn-cancel btn-custom">Delete Reservation</button>
                            </form>

                            <button class="btn btn-print btn-custom" id="download-pdf">Print Voucher</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script>
    document.getElementById('download-pdf').addEventListener('click', function() {
        // Initialize jsPDF
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        const reservation = {
            id: '<?php echo $reservation->getIdReservation(); ?>',
            startDate: '<?php echo $reservation->getDebutReservation(); ?>',
            endDate: '<?php echo $reservation->getFinReservation(); ?>',
            description: '<?php echo $reservation->getDescription(); ?>'
        };

        const employee = {
            name: '<?php echo $employee->getNom() . ' ' . $employee->getPrenom(); ?>',
            email: '<?php echo $employee->getEmail(); ?>',
            phone: '<?php echo $employee->getTelephone(); ?>'
        };

        doc.setFontSize(16);
        doc.text('Reservation Details', 20, 20);

        doc.setFontSize(12);
        doc.text(`Reservation ID: ${reservation.id}`, 20, 30);
        doc.text(`Start Date: ${reservation.startDate}`, 20, 40);
        doc.text(`End Date: ${reservation.endDate}`, 20, 50);
        doc.text(`Description: ${reservation.description}`, 20, 60);

        doc.text('Employee Information', 20, 80);
        doc.text(`Name: ${employee.name}`, 20, 90);
        doc.text(`Email: ${employee.email}`, 20, 100);
        doc.text(`Phone: ${employee.phone}`, 20, 110);

        doc.save(`reservation_${reservation.id}.pdf`);
    });
    </script>

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
                document.getElementById('profileName').textContent = userName;
                document.getElementById('profileImage').src = userImage;
            } catch (error) {
                console.error('Error decoding the token:', error);
            }
        }
    });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="assets/vendors/js/vendor.bundle.base.js">
    <!-- endinject 
    -->
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
</body>

</html>