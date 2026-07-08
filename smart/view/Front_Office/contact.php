<?php
require_once __DIR__.'/../../Controller/EmployeController.php';
require_once __DIR__.'/../../Controller/ReservationController.php'; // Corrected file path

$reservationController = new ReservationController();

$message = '';
$employeController = new EmployeController();
$approvedEmployees = $employeController->getApprovedEmployees();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../Config.php';
require __DIR__ . '/../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_id']) && $_POST['form_id'] === 'contact_form') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $status = 'approved';

    $token = bin2hex(random_bytes(16)); // Generates a 32-character random token 
    var_dump($token);
    $employeController = new EmployeController();

    if ($employeController->createEmploye($nom, $prenom, $email, $telephone, $status,$token)) {
        
        $mail = new PHPMailer(true);

        try {
            configureMailer($mail);
            $mail->addAddress($email, "$prenom $nom");
            $confirmationLink = "http://localhost/projet%20(1)/projet/view/front/template/confirm.php?token=$token";
            $mail->isHTML(true);
            $mail->Subject = 'Confirm Your Email';
            $mail->Body    = "
                <h2>Email Confirmation</h2>
                <p>Dear $prenom $nom,</p>
                <p>Thank you for registering. Please click the link below to confirm your email:</p>
                <p><a href='$confirmationLink'>Confirm Email</a></p>
                <p>If you did not sign up, please ignore this email.</p>
            ";

            $mail->send();
            $message = "Employee added successfully! A confirmation email has been sent to $email.";
        } catch (Exception $e) {
            $message = "Employee added, but the confirmation email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $message = "Error adding employee.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>falle7a - Organic Food Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="css/chatbot.css" rel="stylesheet" />

    <link href="img/favicon.ico" rel="icon">

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
                        <a href="#" class="nav-link dropdown-toggle" id="servicesDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item" href="services.php">view our approved employees</a></li>
                            <li><a class="dropdown-item" href="service_page.php#view_services">View our services</a>
                            </li>
                            <li><a class="dropdown-item" href="service_page.php#service_request">Request a Service</a>
                            </li>
                            <li><a class="dropdown-item" href="service_page.php#history_service">View Service
                                    History</a></li>
                        </ul>
                    </div>
                    <a href="#" class="nav-item nav-link active">Contact Us</a>
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
            <h1 class="display-3 mb-3 animated slideInDown">Contact Us</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-body" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-body" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-dark active" aria-current="page">Contact Us</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container-xxl py-6">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
                style="max-width: 500px;">
                <h1 class="display-5 mb-3">Contact Us</h1>
                <p>Tempor ut dolore lorem kasd vero ipsum sit eirmod sit. Ipsum diam justo sed rebum vero dolor duo.</p>
            </div>
            <div class="row g-5 justify-content-center">
                <div class="col-lg-5 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-primary text-white d-flex flex-column justify-content-center h-100 p-5">
                        <h5 class="text-white">Call Us</h5>
                        <p class="mb-5"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <h5 class="text-white">Email Us</h5>
                        <p class="mb-5"><i class="fa fa-envelope me-3"></i>contact@falle7a.local</p>
                        <h5 class="text-white">Office Address</h5>
                        <p class="mb-5"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <h5 class="text-white">Follow Us</h5>
                        <div class="d-flex pt-2">
                            <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i
                                    class="fab fa-youtube"></i></a>
                            <a class="btn btn-square btn-outline-light rounded-circle me-0" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 wow fadeInUp" data-wow-delay="0.5s">
                    <?php if ($message): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $message; ?>
                    </div>
                    <?php endif; ?>
                    <p class="mb-4">The contact form is currently inactive. Get a functional and working contact form
                        with Ajax & PHP in a few minutes. Just copy and paste the files, add a little code and you're
                        done. <a href="https://htmlcodex.com/contact-form">Download Now</a>.</p>
                    <form action="" method="post" id="contact_form">
                        <input type="hidden" name="form_id" value="contact_form">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="nom" class="form-control" id="name"
                                        placeholder="Your Name">
                                    <label for="name">Nom</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="prenom" class="form-control" id="name"
                                        placeholder="Your Name">
                                    <label for="name">Prénom</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input name="email" type="email" class="form-control" id="email"
                                        placeholder="Your Email">
                                    <label for="email">Your Email</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input class="form-control" name="telephone" placeholder="Phone" id="message">
                                    <label for="message">Telephone</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary rounded-pill py-3 px-5" type="submit">Send
                                    Message</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl bg-light bg-icon  py-6" style="max-width:100%">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
                style="max-width:500px">
                <h1 class="display-5 mb-3">Submit Your Reclamation Request</h1>
                <p>Describe the issue or service concern, and we will address it promptly.</p>
            </div>
            <div class="row g-5 justify-content-center">
                <div class="col-lg-7 col-md-12 wow fadeInUp" data-wow-delay="0.5s">
                    <form id="form" onsubmit="return handle_form(event);" method="GET" action="add_reclamtion.php">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="reclamtion" id="description"
                                        name="description" style="height:200px"></textarea>
                                    <label for="description">Service Description</label>
                                    <small class="text-danger d-none" id="description-error">Service description cannot
                                        be empty.</small>
                                </div>
                            </div>
                            <div class="col-12"><button class="btn btn-primary rounded-pill py-3 px-5"
                                    type="submit">Submit Request</button></div>
                            <small id="form_message"></small>
                            <script>
                            const Description = document.getElementById("description");
                            const serviceForm = document.getElementById("form");

                            function checkField(field, errorId) {
                                const errorElement = document.getElementById(errorId);
                                if (!field.value.trim()) {
                                    errorElement.classList.remove("d-none");
                                    field.classList.add("is-invalid");
                                    return false;
                                } else {
                                    errorElement.classList.add("d-none");
                                    field.classList.remove("is-invalid");
                                    return true;
                                }
                            }

                            function handle_form(event) {
                                let isValid = true;
                                if (!checkField(Description, "description-error")) isValid = false;
                                return isValid;
                            }
                            Description.addEventListener("input", () => checkField(Description, "description-error"));
                            </script>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5" style="display:flex;justify-content:space-between">
                <div class="col-lg-3 col-md-6">
                    <h1 class="fw-bold text-primary mb-4">FALLE<span class="text-secondary">7</span>A</h1>
                    <p>Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed
                        stet lorem sit clita</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href="#"><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href="#"><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href="#"><i
                                class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-0" href="#"><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Address</h4>
                    <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p><i class="fa fa-envelope me-3"></i>contact@falle7a.local</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="#">About Us</a>
                    <a class="btn btn-link" href="#">Contact Us</a>
                    <a class="btn btn-link" href="#">Our Services</a>
                    <a class="btn btn-link" href="#">Terms & Condition</a>
                    <a class="btn btn-link" href="#">Support</a>
                </div>
            </div>
        </div>
        <div class="container-fluid copyright">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">&copy; <a href="#">Your Site Name</a>, All Right Reserved.</div>
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

    <script src="js/main.js"></script>
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
    <script src="js/chatbot.js"></script>
</body>

</html>
