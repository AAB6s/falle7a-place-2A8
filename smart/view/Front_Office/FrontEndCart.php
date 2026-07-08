<?php
require_once __DIR__ . '/../../Controller/OrderController.php';
require __DIR__ . '/../../vendor/autoload.php';

$orderController = new OrderController();
$orders = $orderController->listOrders(); // Fetch updated orders from the database
$topProducts = $orderController->listTopPurchasedProducts();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />

    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Cart</title>
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <link href="img/favicon.ico" rel="icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="css/chatbot.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap"
        rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <link href="lib/animate/animate.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <link href="css/style.css" rel="stylesheet" />

    <script>
    window.addEventListener('beforeunload', () => {
        localStorage.setItem('scrollPosition', window.scrollY);
    });

    window.addEventListener('load', () => {
        const scrollPosition = localStorage.getItem('scrollPosition');
        if (scrollPosition) {
            window.scrollTo(0, parseInt(scrollPosition, 10));
            localStorage.removeItem('scrollPosition'); // Clean up storage
        }
    });
    </script>
</head>

<body>
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt me-2"></i>123 Street, New York,
                    USA</small>
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
                <h1 class="fw-bold text-primary m-0">
                    FALLE<span class="text-secondary">7</span>A
                </h1>
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
    <div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <h1 class="display-3 mb-3 animated slideInDown">Cart</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-body" href="#">Home</a>
                    </li>
                    <li class="breadcrumb-item text-dark active" aria-current="page">
                        cart
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="wow fadeInUp" data-wow-delay="0.1s" style="max-width: 1200px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <h1 style="text-align: center; color: #333;">Orders Manager</h1>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background-color: #f4f4f4; color: #333;">
                    <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Product Name</th>
                    <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Description</th>
                    <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Price</th>
                    <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Quantity</th>
                    <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr style="background-color: <?= ($order['order_id'] % 2 == 0) ? '#f9f9f9' : '#fff'; ?>;">
                    <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($order['Nom']); ?></td>
                    <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($order['Description']); ?>
                    </td>
                    <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($order['Prix']); ?></td>
                    <td style="padding: 12px; border: 1px solid #ddd;">
                        <form method="POST" action="updateOrder.php" style="display: inline;">
                            <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                            <input type="number" name="quantity" value="<?= htmlspecialchars($order['quantity']); ?>"
                                style="padding: 6px; width: 60px; border: 1px solid #ddd; border-radius: 4px;"
                                oninput="validateQuantity(this)">
                            <button type="submit" style="padding: 6px 12px; border: none;
                                  background-color: #007bff; color: white; border-radius: 4px; cursor: pointer; 
                                  transition: transform 0.3s, background-color 0.3s; margin-left: 50px;"
                                onmouseover="this.style.transform = 'scale(1.1)'; this.style.backgroundColor = '#0056b3';"
                                onmouseout="this.style.transform = 'scale(1)'; this.style.backgroundColor = '#007bff';">
                                Apply Changes
                            </button>
                        </form>
                    </td>

                    <td style="padding: 12px; border: 1px solid #ddd;">
                        <form method="POST" action="deleteOrder.php" style="display: inline;">
                            <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                            <button style="padding: 6px 12px; border: none; 
                                background-color: #dc3545; color: white; border-radius: 4px; cursor: pointer; 
                                transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.1)';"
                                onmouseout="this.style.transform='scale(1)';">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <div align="right">
            <form action="send_email.php">
                <button id="checkoutBtn" type="submit"
                    style="padding: 6px 12px; border: none; background-color: #007bff; color: white; border-radius: 4px; cursor: pointer; transition: transform 0.3s;">
                    Check Out
                </button>

            </form>
        </div>

        <div class="container my-5" style="max-width: 1200px; margin: 0 auto;">
            <div class="text-center mb-4">
                <h2 class="section-title" style="font-size: 1.8rem; font-weight: bold; color: #333;">Top 5 Most Popular
                    Products
                </h2>
            </div>

            <div class="d-flex justify-content-center mb-4">
                <button class="btn btn-secondary btn-sm me-2" id="prevProduct"
                    style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="fa fa-arrow-left"></i>
                </button>
                <button class="btn btn-secondary btn-sm" id="nextProduct"
                    style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>

            <div class="row" id="productCarousel" style="display: flex; justify-content: center; gap: 16px;">
                <div class="col-md-6 product-card" style="padding: 0 16px; text-align: center;">
                    <div class="product-item"
                        style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; transition: transform 0.2s ease-in-out;">
                        <h3 class="h5 mb-2" style="font-size: 1.5rem; font-weight: bold; color: #333;">
                            <?php echo htmlspecialchars($topProducts[0]['Nom']); ?>
                        </h3>
                        <span class="text-primary fw-bold"
                            style="font-size: 1.2rem;"><?php echo number_format($topProducts[0]['Prix'], 2); ?>
                            dt</span>
                        <div class="product-rank" style="font-size: 0.9rem; color: #888; margin-top: 10px;">
                            Rank <?php echo 1; ?>
                        </div>
                        <div class="mt-3">
                            <a class="btn btn-primary" href="#">
                                <i class="fa fa-eye text-white me-2"></i> View Details
                            </a>
                            <a class="btn text-body" href="#"
                                onclick="add('<?php echo $topProducts[0]['Id_Produit']; ?>');">
                                <i class="fa fa-shopping-bag text-primary me-2"></i>Ajouter au panier
                            </a>
                            <script>
                            function add(productId) {
                                console.log('Product ID:', productId); // Debugging
                                const token = localStorage.getItem('token');
                                const clientId = JSON.parse(atob(token.split('.')[1])).data.id;

                                if (!productId) {
                                    alert('Product ID is missing!');
                                    return;
                                }

                                const url =
                                    `addProduct.php?id=${encodeURIComponent(productId)}&clientId=${encodeURIComponent(clientId)}`;
                                console.log('URL:', url); // Log the final URL
                                window.location.href = url;
                            }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const productCarousel = document.getElementById("productCarousel");
            const prevButton = document.getElementById("prevProduct");
            const nextButton = document.getElementById("nextProduct");

            let currentProductIndex = 0;

            const products = <?php echo json_encode($topProducts); ?>; // JSON array of products

            function displayProduct(index) {
                const product = products[index];
                productCarousel.innerHTML = `
                <div class="col-md-6 product-card" style="padding: 0 16px; text-align: center;">
                    <div class="product-item" style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; transition: transform 0.2s ease-in-out;">
                        <h3 class="h5 mb-2" style="font-size: 1.5rem; font-weight: bold; color: #333;">${product.name}</h3>
                        <span class="text-primary fw-bold" style="font-size: 1.2rem;">${product.price} dt</span>
                        <div class="product-rank" style="font-size: 0.9rem; color: #888; margin-top: 10px;">
                            Rank ${index + 1}
                        </div>
                        <div class="mt-3">
                            <a class="btn btn-primary" href="product-detail.php?product_id=${product.product_id}" style="color: #fff; text-decoration: none;">
                                <i class="fa fa-eye text-white me-2"></i> View Details
                            </a>
                            <a class="btn btn-success" href="addProduct.php?product_id=${product.product_id}&quantity=1&client_id=1" style="color: #fff; text-decoration: none;">
                                <i class="fa fa-shopping-bag text-white me-2"></i> Add to Cart
                            </a>
                        </div>
                    </div>
                </div>
            `;
            }

            displayProduct(currentProductIndex);

            prevButton.addEventListener("click", function() {
                if (currentProductIndex > 0) {
                    currentProductIndex--;
                } else {
                    currentProductIndex = products.length - 1; // Loop to the last product
                }
                displayProduct(currentProductIndex);
            });

            nextButton.addEventListener("click", function() {
                if (currentProductIndex < products.length - 1) {
                    currentProductIndex++;
                } else {
                    currentProductIndex = 0; // Loop to the first product
                }
                displayProduct(currentProductIndex);
            });
        });
        </script>


    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
                style="max-width: 500px">
                <h1 class="display-5 mb-3">Customer Review</h1>
                <p>See what our clients have to say about our services.</p>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <i class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"></i>
                    <p class="mb-4">
                        The service was exceptional and the team was very professional.
                        Highly recommended!
                    </p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="img/testimonial-1.jpg" alt="Client Image" />
                        <div class="ms-3">
                            <h5 class="mb-1">John Doe</h5>
                            <span>Project Manager</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <i class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"></i>
                    <p class="mb-4">
                        Amazing experience! I’m very pleased with the service provided.
                    </p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="img/testimonial-2.jpg" alt="Client Image" />
                        <div class="ms-3">
                            <h5 class="mb-1">Sarah Lee</h5>
                            <span>Entrepreneur</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <i class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"></i>
                    <p class="mb-4">
                        I will definitely be using their services again in the future.
                    </p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="img/testimonial-3.jpg" alt="Client Image" />
                        <div class="ms-3">
                            <h5 class="mb-1">Michael Smith</h5>
                            <span>Freelancer</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <i class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"></i>
                    <p class="mb-4">
                        The team was highly responsive and catered to all my requirements.
                    </p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="img/testimonial-4.jpg" alt="Client Image" />
                        <div class="ms-3">
                            <h5 class="mb-1">Emma Johnson</h5>
                            <span>Software Engineer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5" style="display: flex; justify-content: space-between">
                <div class="col-lg-3 col-md-6">
                    <h1 class="fw-bold text-primary mb-4">
                        FALLE<span class="text-secondary">7</span>A
                    </h1>
                    <p>
                        Fallla7a is good
                    </p>
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
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Address</h4>
                    <p>
                        <i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA
                    </p>
                    <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p><i class="fa fa-envelope me-3"></i>contact@falle7a.local</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
            </div>
        </div>
        <div class="container-fluid copyright">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
    function validateQuantity(input) {

        if (input.value < 1) {

            input.value = 1;
        }
    }
    </script>
<div class="floating-chat">
      <i class="fa fa-comments" aria-hidden="true"></i>
      <div class="chat">
        <div class="header">
          <span class="title"> what's on your mind? </span>
          <button>
            <i class="fa fa-times" aria-hidden="true"></i>
          </button>
        </div>
        <ul class="messages">
          <li class="other">
            <img
              src="https://i.pinimg.com/736x/f5/96/9d/f5969dc8d64385ae8fb66b4aafbf2ad5.jpg"
              alt="Chatbot Avatar"
            />
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
    <script src="js/chatbot.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>


    <script>
    function updateCartCount() {
        $.ajax({
            url: 'getOrderCount.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.orderCount !== undefined) {
                    $('#cart-count').text(response.orderCount);

                    if (response.orderCount < 1) {
                        $('#checkoutBtn').prop('disabled', true).css({
                            'background-color': '#ccc',
                            'cursor': 'not-allowed'
                        });
                    } else {
                        $('#checkoutBtn').prop('disabled', false).css({
                            'background-color': '#007bff',
                            'cursor': 'pointer'
                        });
                    }
                } else {
                    console.log("Error: orderCount is undefined.");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", status, error);
            }
        });
    }

    $(document).ready(function() {
        updateCartCount();
    });
    </script>








</body>
</body>

</html>
