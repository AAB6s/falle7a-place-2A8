<?php

require_once '../../Controller/TravelOfferController.php';

$controller = new TravelOfferController();
$offers = $controller->listOffers();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Travel Offers</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <link href="assets/css/styles.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<style>
		body *:not(input):not(textarea) 
		{
			caret-color: transparent;
		}
		
		body
		{
			font-size: 16px;
		}
		input, textarea
		{
			caret-color: auto;
		}

		h2.page-section-heading
		{
			font-size: 2.5rem;
		}

		h4
		{
			font-size: 1.75rem;
		}

		p, .lead
		{
			font-size: 1.125rem;
		}

		i
		{
			font-size: 4rem;
		}

		a.btn-xl 
		{
			font-size: 1.125rem;
			padding: 1rem 1.5rem;
		}
		.modal-xl 
		{
			max-width: 80%;
		}

		.modal-body img
		{
			width: 70%;
		}

		.modal-body
		{
			font-size: 1.125rem;
		}
		
		.navbar-brand i 
		{
			font-size: 1.5rem;
			margin-right: 10px;
			color: white; 
			vertical-align: middle;
		}

		.navbar-brand:hover i 
		{
			color: #f0ad4e; 
			transform: scale(1.1);
			transition: transform 0.2s, color 0.2s;
		}
		
        .travel-offers-table-container{max-width:1000px;margin:0 auto;padding-top:20px;}.travel-offers-table{width:100%;border-collapse:collapse;background-color:#ffffff;box-shadow:0px 4px 8px rgba(0,0,0,0.1);border-radius:8px;overflow:hidden;}.travel-offers-table th,.travel-offers-table td{padding:12px 15px;text-align:center;}.travel-offers-table th{background-color:#2c3e50;color:#ffffff;font-weight:bold;}.travel-offers-table tr:nth-child(even){background-color:#f4f6f9;}.travel-offers-table tr:nth-child(odd){background-color:#ffffff;}.travel-offers-table tr:hover{background-color:#d1e7f0;}.travel-offers-table td{color:#333333;border-bottom:1px solid #ddd;}.no-offers-message{text-align:center;padding:20px;color:#888888;font-size:1.1rem;}

	</style>
</head>
<body id="page-top">
	<!-- Navigation-->
	<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
		<div class="container">
			<a class="navbar-brand" href="#page-top">
				<i class="fas fa-plane"></i> Travel Booking
			</a>
			<button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				Menu<i class="fas fa-bars"></i>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#offers">Travel Offers</a></li>
					<li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#top-offers">Top Offers</a></li>
					<li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#about">About</a></li>
					<li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#contact">Contact</a></li>
					<li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#footer">Footer</a></li>
				</ul>
			</div>
		</div>
	</nav>

    <!-- Travel Offers Section -->
    <section class="page-section bg-primary text-white mb-0" id="offers" style="padding-top: 140px;">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-white">Travel Offers</h2>
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-suitcase"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="row justify-content-center" style="margin-top: 50px;">
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="text-center">
                        <i class="fas fa-users fa-5x"></i>
                        <h4 class="mt-3">Family Trips</h4>
                        <p>Enjoy quality family time at top destinations.</p>
                        <a href="#" class="btn btn-xl btn-outline-light">Explore</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="text-center">
                        <i class="fas fa-heart fa-5x"></i>
                        <h4 class="mt-3">Couples' Trips</h4>
                        <p>Discover romantic getaways for two.</p>
                        <a href="#" class="btn btn-xl btn-outline-light">Explore</a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="text-center">
                        <i class="fas fa-hiking fa-5x"></i>
                        <h4 class="mt-3">Adventure Trips</h4>
                        <p>Discover thrilling experiences around the globe.</p>
                        <a href="#" class="btn btn-xl btn-outline-light">Explore</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="text-center">
                        <i class="fas fa-futbol fa-5x"></i>
                        <h4 class="mt-3">Sports Trips</h4>
                        <p>Explore exciting sports adventures worldwide.</p>
                        <a href="#" class="btn btn-xl btn-outline-light">Explore</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Offers Section -->
    <section class="page-section portfolio" id="top-offers">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Top Offers</h2>
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal1">
                        <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/circus.png" alt="Circus Offer" style="width: 100%;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal2">
                        <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/cabin.png" alt="Cabin Offer" style="width: 100%;" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal3">
                        <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/submarine.png" alt="Submarine Offer" style="width: 100%;" />
                    </div>
                </div>
            </div>
        </div>
			<!-- List of Travel Offers from Database -->
			<center>
				<div class="row justify-content-center" style="margin: 30px auto; max-width: 90%;">
					<div class="col-lg-12">
						<h2 class="page-section-heading text-center text-uppercase text-secondary mb-3">Explore All Our Offers</h2>
						<div class="divider-custom mb-4">
							<div class="divider-custom-line"></div>
							<div class="divider-custom-icon"><i class="fas fa-star"></i></div>
							<div class="divider-custom-line"></div>
						</div>
						<div class="travel-offers-table-container">
							<?php 
								$controller = new TravelOfferController();
								if ($offers) 
									$controller->showTravelOffers($offers);
								else 
									echo "<p class='no-offers-message text-center'>No travel offers available at the moment.</p>";
							?>
						</div>
					</div>
				</div>
			</center>
    </section>
	


    <!-- Modal 1 for Top Offer 1 -->
    <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" aria-labelledby="portfolioModal1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center pb-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Circus Offer</h2>
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <img class="img-fluid rounded mb-5" src="assets/img/portfolio/circus.png" alt="..." />
                                <p class="mb-4">Experience a vibrant circus adventure like never before! Enjoy a full day of performances, exciting rides, and a variety of snacks. Perfect for family fun.</p>
                                <button class="btn btn-primary"><i class="fas fa-book fa-fw"></i> Book Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2 for Top Offer 2 -->
    <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" aria-labelledby="portfolioModal2" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center pb-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Cabin Offer</h2>
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <img class="img-fluid rounded mb-5" src="assets/img/portfolio/cabin.png" alt="..." />
                                <p class="mb-4">Escape to a peaceful cabin in the woods, surrounded by nature and tranquility. Ideal for those looking for a quiet retreat and scenic hiking trails.</p>
                                <button class="btn btn-primary"><i class="fas fa-book fa-fw"></i> Book Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3 for Top Offer 3 -->
    <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" aria-labelledby="portfolioModal3" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center pb-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Submarine Offer</h2>
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <img class="img-fluid rounded mb-5" src="assets/img/portfolio/submarine.png" alt="..." />
                                <p class="mb-4">Dive deep into the ocean with our unique submarine experience. Explore marine life, underwater landscapes, and the mysteries of the sea up close.</p>
                                <button class="btn btn-primary"><i class="fas fa-book fa-fw"></i> Book Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section-->
    <section class="page-section bg-primary text-white mb-0" id="about">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-white">About Us</h2>
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="row">
                <div class="col-lg-6 ms-auto">
                    <p class="lead">
                        A travel agency specializing in customized holidays wants to modernize its online booking system.
                        Currently, customers have to contact the agency by phone or<br>e-mail to book their trips,
                        resulting in delays and inefficiencies.
                    </p>
                </div>
                <div class="col-lg-6 me-auto">
                    <p class="lead">
                        The agency needs an online solution that will enable customers to browse offers, personalize
                        their trips, and book autonomously—bringing convenience and freedom to your travel planning.
                    </p>
                </div>
            </div>
            <div class="text-center mt-4">
                <a class="btn btn-xl btn-outline-light" href="#offers"><i class="fas fa-suitcase me-2"></i>Explore Offers</a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="page-section" id="contact">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-4">Contact Us</h2>
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-envelope"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="text-center mb-4">
                <p class="lead">You can reach us via email: <a href="mailto:contact@esprit.tn">contact@esprit.tn</a></p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    <form id="contactForm" novalidate>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="name" type="text" placeholder="Enter your name..." required />
                            <label for="name">Full name</label>
                            <div class="invalid-feedback">A name is required.</div>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="email" type="email" placeholder="name@example.com" required />
                            <label for="email">Email address</label>
                            <div class="invalid-feedback">A valid email is required.</div>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="phone" type="number" placeholder="(123) 456-7890" required />
                            <label for="phone">Phone number</label>
                            <div class="invalid-feedback">A phone number is required.</div>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="message" placeholder="Enter your message here..." style="height: 10rem" required></textarea>
                            <label for="message">Message</label>
                            <div class="invalid-feedback">A message is required.</div>
                        </div>
                        <div id="submitSuccessMessage" class="d-none">
                            <div class="text-center mb-3">
                                <div class="fw-bolder">Form submission successful!</div>
                            </div>
                        </div>
                        <div id="submitErrorMessage" class="d-none">
                            <div class="text-center text-danger mb-3">Error sending message!</div>
                        </div>
                        <button class="btn btn-primary btn-xl" id="submitButton" type="submit" disabled>Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
    document.addEventListener("DOMContentLoaded",function(){
        const form=document.getElementById('contactForm'),successMessage=document.getElementById('submitSuccessMessage'),errorMessage=document.getElementById('submitErrorMessage'),inputs=form.querySelectorAll('input, textarea'),submitButton=document.getElementById('submitButton');
        function checkFormValidity(){submitButton.disabled=!form.checkValidity();}
        inputs.forEach(input=>
		{
            input.addEventListener('input',checkFormValidity);
            input.addEventListener('blur',checkFormValidity);
        });
        checkFormValidity();
        form.addEventListener('submit',function(event)
		{
            event.preventDefault();
            successMessage.classList.add('d-none');
            errorMessage.classList.add('d-none');
            if(!form.checkValidity())
				form.classList.add('was-validated');
            else
			{
                successMessage.classList.remove('d-none');
                form.classList.remove('was-validated');
                inputs.forEach(input=>input.disabled=true);
                submitButton.disabled=true;
            }
        });
    });
    </script>

    <!-- Footer Section -->
    <footer class="footer text-center" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <h4 class="text-uppercase mb-4">Follow Us Around the Web</h4>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="col-lg-12 mb-5">
                    <h4 class="text-uppercase mb-4">Our Location</h4>
                    <p class="lead mb-0">Location: 1, 2 rue André Ampère - 2083 Technological Pole - El Ghazala</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Copyright Section -->
    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Copyright &copy; Your Website 2024</small></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>