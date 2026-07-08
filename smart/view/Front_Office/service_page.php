<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Foody - Organic Food Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />
    <link href="css/chatbot.css" rel="stylesheet" />
    <link href="img/favicon.ico" rel="icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="lib/animate/animate.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body>
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt me-2"></i>123 Street, New York, USA</small>
                <small class="ms-4"><i class="fa fa-envelope me-2"></i>contact@falle7a.local</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Follow us:</small>
                <a class="text-body ms-3" href="#"><i class="fab fa-facebook-f"></i></a>
                <a class="text-body ms-3" href="#"><i class="fab fa-twitter"></i></a>
                <a class="text-body ms-3" href="#"><i class="fab fa-linkedin-in"></i></a>
                <a class="text-body ms-3" href="#"><i class="fab fa-instagram"></i></a>
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
                            <li><a class="dropdown-item" href="services.php">view our approved employees</a></li>
                            <li><a class="dropdown-item" href="#view_services">View our services</a></li>
                            <li><a class="dropdown-item" href="#service_request">Request a Service</a></li>
                            <li><a class="dropdown-item" href="#history_service">View Service History</a></li>
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
    <div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <h1 class="display-3 mb-3 animated slideInDown">Services</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-body" href="#">Home</a></li>
                    <li class="breadcrumb-item text-dark active" aria-current="page">Services</li>
                </ol>
            </nav>
        </div>
    </div>

    <div id="view_service" class="container py-6">
        <div class="section-header text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="display-5">Available Services</h1>
            <p>Explore and filter through the services we offer to meet your needs.</p>
        </div>
        <div class="wow fadeInUp" data-wow-delay="1s">
            <ul class="nav nav-tabs justify-content-center mb-4" id="service-type-filters">
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active">
                    <h3 id="service_type_title" class="mb-4 text-center">All Services</h3>
                    <small id="service_type_description" class="text-muted d-block text-center mb-4">All available
                        services.</small>
                    <div id="filtered_services" class="row"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="service_request" class="container-xxl bg-light bg-icon  py-6" style="max-width:100%">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
                style="max-width:500px">
                <h1 class="display-5 mb-3">Request a Service</h1>
                <p>Provide the details of the service you need, and we’ll get back to you as soon as possible.</p>
            </div>
            <div class="row g-5 justify-content-center">
                <div class="col-lg-7 col-md-12 wow fadeInUp" data-wow-delay="0.5s">
                    <form id="service-form" onsubmit="handle_form(event);" method="POST">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select" id="service-selection" name="service_selection">
                                        <option disabled selected>Select a Service</option>
                                        <option>Custom Service</option>
                                    </select>
                                    <label for="service-selection">Service Selection</label>
                                    <small class="text-danger d-none" id="service-selection-error">Please select a
                                        service.</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Service Description" id="description"
                                        name="description" style="height:200px" readonly></textarea>
                                    <label for="description">Service Description</label>
                                    <small class="text-danger d-none" id="description-error">Service description cannot
                                        be empty.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="preferred-date" name="preferred_date" />
                                    <label for="preferred-date">Preferred Date</label>
                                    <small class="text-danger d-none" id="preferred-date-error">Please select a
                                        preferred date.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="time" class="form-control" id="preferred-time" name="preferred_time" />
                                    <label for="preferred-time">Preferred Time</label>
                                    <small class="text-danger d-none" id="preferred-time-error">Please select a
                                        preferred time.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="worker-count" name="worker_count"
                                        placeholder="Number of Workers (Optional)" value="1" min="1" />
                                    <label for="worker-count">Number of Workers</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Any special instructions"
                                        id="instructions" name="instructions" style="height:100px"></textarea>
                                    <label for="instructions">Special Instructions (Optional)</label>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="address-input"
                                    placeholder="Enter location name or address" name="location">
                                <label for="address-input">Enter location name or address</label>
                                <small class="text-info" id="address-input-error"></small>
                            </div>
                            <div id="map" style="height: 40vh; width: 100%;"></div>
                            <div class="col-12"><button class="btn btn-primary rounded-pill py-3 px-5" type="submit"
                                    id="submit-button">Submit Request</button></div>
                            <small id="form_message"></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="history_service" class="container py-6">
        <div class="section-header text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="display-5">Service Request History</h1>
            <p>View the history of your service requests.</p>
        </div>
        <div class="wow fadeInUp" data-wow-delay="0.5s">
            <ul class="nav nav-tabs justify-content-center mb-4">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#all" id="all_filter">All</a>
                </li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#pending"
                        id="pending_filter">Pending</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#approved"
                        id="approved_filter">Approved</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#disapproved"
                        id="disapproved_filter">Disapproved</a></li>
            </ul>
            <div class="tab-content">
                <div id="all" class="tab-pane fade show active">
                    <h3 class="mb-4 text-center">All Service Requests</h3>
                    <div class="row" id="all-requests"></div>
                </div>
                <div id="pending" class="tab-pane fade">
                    <h3 class="mb-4 text-center">Pending Requests</h3>
                    <div class="row" id="pending-requests"></div>
                </div>
                <div id="approved" class="tab-pane fade">
                    <h3 class="mb-4 text-center">Approved Requests</h3>
                    <div class="row" id="approved-requests"></div>
                </div>
                <div id="disapproved" class="tab-pane fade">
                    <h3 class="mb-4 text-center">Disapproved Requests</h3>
                    <div class="row" id="disapproved-requests"></div>
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
    <script src="js/service.js" defer></script>
    <script src="js/chatbot.js"></script>
</body>

</html>
