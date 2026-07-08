<?php
require_once '../../Controller/EmployeController.php';
require_once '../../Controller/ReservationController.php'; // Corrected file path

$reservationController = new ReservationController();

$message = '';
$employeController = new EmployeController();
$approvedEmployees = $employeController->getApprovedEmployees();


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['form_id']) && $_POST['form_id'] === 'reservation_form') {
    $debut_reservation = $_POST['debut_reservation'];
    $fin_reservation = $_POST['fin_reservation'];
    $description = $_POST['description'];
    $employee_id = $_POST['employee_id']; // Get the employee ID from the form

    if ($reservationController->createReservation($debut_reservation, $fin_reservation, $description, $employee_id)) {
        $message = "Réservation pour ajoutée avec succès !";
    } else {
        $message = "Worker est n'est pas disponible, Essayer dans un autre periode";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Foody - Organic Food Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="img/favicon.ico" rel="icon">

    <link href="css/chatbot.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">
    <style>
    .card:hover {
        transform: scale(1.05);
        /* Slightly increase the size */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        /* Add a subtle shadow */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Smooth transition */
    }

    .card-body {
        transition: background-color 0.3s ease;
        /* Smooth background transition */
    }

    .card:hover .card-body {
        background-color: rgba(0, 128, 0, 0.05);
        /* Change background on hover */
    }
    </style>
</head>

<body>
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>


    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt me-2"></i>123 Street, New York, USA</small>
                <small class="ms-4"><i class="fa fa-envelope me-2"></i>contact@falle7a.local</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Follow us:</small>
                <a class="text-body ms-3" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-twitter"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-linkedin-in"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            <a href="index.html" class="navbar-brand ms-4 ms-lg-0">
                <h1 class="fw-bold text-primary m-0">FALLE<span class="text-secondary">7</span>A</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.html" class="nav-item nav-link">Home</a>
                    <a href="../ListeProduits.php" class="nav-item nav-link">Products</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle active" id="servicesDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item" href="#">view our approved employees</a></li>
                            <li><a class="dropdown-item" href="service_page.php#view_services">View our services</a>
                            </li>
                            <li><a class="dropdown-item" href="service_page.php#service_request">Request a Service</a>
                            </li>
                            <li><a class="dropdown-item" href="service_page.php#history_service">View Service
                                    History</a></li>
                        </ul>
                    </div>
                    <a href="contact.php" class="nav-item nav-link">Contact Us</a>
                    <a href="#" class="nav-item nav-link">About Us</a>
                </div>
                <div class="d-none d-lg-flex ms-2">
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="#"><small
                            class="fa fa-search text-body"></small></a>
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="../logout.php"><small
                            class="fa fa-user text-body"></small></a>
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="cart.html">
                        <small class="fa fa-shopping-bag text-body"></small>
                        <span id="cart-count"
                            style="position: absolute; right: 40px; background-color: red; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center; border-radius: 50%; color: #fff; top: 60%; margin-bottom:100px;">4</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <div class="container-fluid page-header wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <h1 class="display-3 mb-3 animated slideInDown">Approved Employees</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-body" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-body" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-dark active" aria-current="page">Approved Employees</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-xxl px-1 py-3 wow fadeIn" data-wow-delay="0.1s">
        <?php if ($message): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($approvedEmployees)) : ?>
        <div class="container mt-5">
            <h2 class="mb-4">Meet Our Approved Employees</h2>
            <div class="row">
                <?php foreach ($approvedEmployees as $employee): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4" data-employee-id="<?= $employee['id']; ?>">
                        <img style="width:200px"
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKYYceDV3_GYxxlHTyG0soWyhrpBlyd1P9xw&s"
                            class="card-img-top" alt="Employee Image">
                        <div class="card-body">
                            <h5 class="card-title text-success">
                                <?= htmlspecialchars($employee['prenom'] . ' ' . $employee['nom']); ?></h5>
                            <p class="card-text">
                                <strong>Email:</strong> <?= htmlspecialchars($employee['email']); ?><br>
                                <strong>Phone:</strong> <?= htmlspecialchars($employee['telephone']); ?><br>
                                <strong>Status:</strong> <?= htmlspecialchars($employee['status']); ?>
                            </p>
                            <button class="btn btn-success w-100" data-bs-toggle="modal"
                                data-bs-target="#reservationModal" data-employee-id="<?= $employee['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-calendar-plus" viewBox="0 0 16 16">
                                    <path
                                        d="M11 0a1 1 0 0 1 1 1v1h3a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H1a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h3V1a1 1 0 0 1 1-1h4zM3 1v1H1v12h14V3h-2V1H3z" />
                                </svg> Add Reservation
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
        <?php else: ?>
        <p>No approved employees found.</p>
        <?php endif; ?>
    </div>

    <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-success" id="reservationModalLabel">Add Reservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" onsubmit="return validateForm()" id="reservation_form">
                        <input type="hidden" name="form_id" value="reservation_form">
                        <input type="hidden" id="employee_id" name="employee_id">

                        <div class="mb-3">
                            <label for="employee_name" class="form-label">Employee:</label>
                            <input type="text" id="employee_name" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="debut_reservation" class="form-label">Start Date and Time:</label>
                            <input type="datetime-local" id="debut_reservation" name="debut_reservation"
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="fin_reservation" class="form-label">End Date and Time:</label>
                            <input type="datetime-local" id="fin_reservation" name="fin_reservation"
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea id="description" name="description" rows="4" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Add Reservation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark footer pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
            </div>
        </div>
    </div>

    </div>


    <div class="floating-chat">
        <i class="fa fa-comments" aria-hidden="true"></i>
        <div class="chat">
            <div class="header">
                <span class="title">
                    what's on your mind?
                </span>
                <button>
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <ul class="messages">
                <li class="other">
                    <img src="https://i.pinimg.com/736x/f5/96/9d/f5969dc8d64385ae8fb66b4aafbf2ad5.jpg"
                        alt="Chatbot Avatar">
                    <span>Hello! How can I assist you today?</span>
                </li>
            </ul>
            <div class="footer">
                <div class="text-box" contenteditable="true" disabled="true"></div>
                <button id="sendMessage">send</button>
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script>
    const buttons = document.querySelectorAll('.btn-success'); // Target buttons in the cards
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const card = button.closest('.card');
            const employeeId = card.getAttribute(
                'data-employee-id'); // Get employee ID from data attribute
            const employeeName = card.querySelector('.card-title')
                .innerText; // Get the employee name from card-title

            document.getElementById('employee_id').value = employeeId;
            document.getElementById('employee_name').value = employeeName;
        });
    });
    </script>

    <script src="js/main.js"></script>
    <script src="js/chatbot.js"></script>
    <script>
    function validateForm() {
        let isValid = true;

        const startDate = document.getElementById('debut_reservation').value;
        const endDate = document.getElementById('fin_reservation').value;
        const description = document.getElementById('description').value;

        document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');

        if (!startDate) {
            document.getElementById('debutError').textContent = 'Veuillez entrer une date de début.';
            isValid = false;
        }

        if (!endDate) {
            document.getElementById('finError').textContent = 'Veuillez entrer une date de fin.';
            isValid = false;
        } else if (startDate && endDate <= startDate) {
            document.getElementById('finError').textContent =
                'La date de fin doit être postérieure à la date de début.';
            isValid = false;
        }

        if (!description) {
            document.getElementById('descriptionError').textContent = 'Veuillez entrer une description.';
            isValid = false;
        }

        return isValid;
    }
    </script>

</body>

</html>
