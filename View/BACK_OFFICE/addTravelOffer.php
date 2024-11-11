<?php

    require_once '../../Controller/TravelOfferController.php';
    
    $controller = new TravelOfferController();
    $offers = $controller->listOffers();
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Travel Booking</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body *:not(input):not(textarea),
        input[type="checkbox"] {
            caret-color: transparent;
        }

        input,
        textarea {
            caret-color: auto;
        }
		.travel-offers-table-container {max-width: 1000px; margin: 0 auto; padding-top: 10px;}.travel-offers-table {width: 100%; border-collapse: collapse; background-color: #fff; box-shadow: 0px 4px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; margin-top: 0;}.travel-offers-table th,.travel-offers-table td {padding: 10px; text-align: left; border-bottom: 1px solid #ddd; font-size: 0.9rem;}.travel-offers-table th {background-color: #f7f9fc; color: #333; font-weight: 600;}.travel-offers-table tr:hover {background-color: #f1f4f9;}.travel-offers-table td {color: #555;}
		</style>
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-plane"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Travel Booking</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.html">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Management</div>
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-suitcase"></i>
                    <span>Manage Offers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Manage Users</span>
                </a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">Alerts Center</h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">Message Center</h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="assets/img/undraw_profile_1.svg" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="assets/img/undraw_profile_2.svg" alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="assets/img/undraw_profile_3.svg" alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">AAB6</span>
                                <img class="img-profile rounded-circle" src="assets/img/undraw_profile.svg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">
                    <h2 class="text-center mb-4">Manage Offers</h2>
                    <div style="display: flex; justify-content: space-between;">
						<div id="display-offers" class="card shadow mb-4" style="width: 45%;">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary">Display Offers</h6>
							</div>
							<div class="card-body">
								<div class="travel-offers-table-container">
									<?php 
										$controller = new TravelOfferController();
										if ($offers)
											$controller->showTravelOffers($offers); 
										else 
											echo "<p class='no-offers-message'>No travel offers available at the moment.</p>";
									?>
								</div>
							</div>
						</div>					
						<div class="card shadow mb-4" style="width: 30%;">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary">Add Offer</h6>
							</div>
							<div class="card-body">
								<form method="POST" action="addOffre.php">
									<div class="form-group">
										<label for="title">Title</label>
										<input type="text" id="title" name="title" class="form-control" placeholder="Enter travel offer title" required>
										<span id="titleMessage"></span>
									</div>
									<div class="form-group">
										<label for="destination">Destination</label>
										<input type="text" id="destination" name="destination" class="form-control" placeholder="Enter destination" required>
										<span id="destinationMessage"></span>
									</div>
									<div class="form-group">
										<label for="departure">Departure Date</label>
										<input type="date" id="departure" name="departure" class="form-control" required>
									</div>
									<div class="form-group">
										<label for="return">Return Date</label>
										<input type="date" id="return" name="return" class="form-control" required>
										<span id="dateMessage"></span>
									</div>
									<div class="form-group">
										<label for="price">Price</label>
										<input type="number" id="price" name="price" class="form-control" min="0" step="0.01" placeholder="Enter price" required>
										<span id="priceMessage"></span>
									</div>
									<div class="form-group">
										<label for="availability">Availability</label>
										<input type="checkbox" id="availability" name="availability" class="form-control" style="display: inline-block; width: auto; height: auto; padding: 0; margin-left: 10px; vertical-align: middle;">
									</div>
									<div class="form-group">
										<label for="category">Category</label>
										<select id="category" name="category" class="form-control" required>
											<option value="" disabled selected>Select a category</option>
											<option value="adventure">Adventure</option>
											<option value="family">Family</option>
											<option value="couples">Couples</option>
											<option value="sports">Sports</option>
										</select>
										<span id="categoryMessage"></span>
									</div>
									<button type="submit" class="btn btn-primary btn-block">Add Offer</button>
								</form>
							</div>
						</div>
						
						<div class="card shadow mb-4" style="width: 30%;">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary">Modify or Delete Offer</h6>
							</div>
							<div class="card-body">
								<form method="POST" id="modifyDeleteForm">
									<input type="hidden" name="action" id="actionType" value="">
									<div class="form-group">
										<label for="modifyId">Offer ID</label>
										<input type="text" id="modifyId" name="id" class="form-control" placeholder="Enter the ID of the offer" required>
										<span id="modifyIdMessage" style="color: red;"></span>
									</div>
									<button type="button" class="btn btn-warning btn-block mb-2" onclick="submitForm('updateOffer.php')">Modify Offer</button>
									<button type="button" class="btn btn-danger btn-block" onclick="submitForm('deleteOffer.php')">Delete Offer</button>
								</form>

								<script>
								function submitForm(actionUrl) 
								{
									const offerId = document.getElementById('modifyId').value.trim();
									const modifyIdMessage = document.getElementById('modifyIdMessage');

									if (!offerId) 
									{
										modifyIdMessage.textContent = 'The offer ID must not be empty.';
										return;
									}
									else 
										modifyIdMessage.textContent = '';
									document.getElementById('modifyDeleteForm').action = actionUrl;
									document.getElementById('modifyDeleteForm').submit();
								}
								</script>
							</div>
						</div>
                    </div>
                </div>
                <footer class="sticky-footer bg-white" style="caret-color: transparent;">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Your Website 2024</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <script src="assets/vendor/jquery/jquery.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="assets/js/sb-admin-2.min.js"></script>
		<script src="assets/js/addOffer.js" type="text/javascript"></script>
    </body>
</html>