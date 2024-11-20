<?php
require_once __DIR__ . '/../../Controller/OrderController.php';

$orderController = new OrderController();
$orders = $orderController->listOrders(); // Fetch updated orders from the database

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
    <title>Foody - Organic Food Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap"
      rel="stylesheet"
    />

    <!-- Icon Font Stylesheet -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Manager</title>
    <script>
        // Save scroll position in local storage before refreshing
        window.addEventListener('beforeunload', () => {
            localStorage.setItem('scrollPosition', window.scrollY);
        });

        // Restore scroll position after page load
        window.addEventListener('load', () => {
            const scrollPosition = localStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, parseInt(scrollPosition, 10));
                localStorage.removeItem('scrollPosition'); // Clean up storage
            }
        });
    </script>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px;">
    <!-- Spinner Start -->
    <div
      id="spinner"
      class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
    >
      <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <div
      class="container-fluid fixed-top px-0 wow fadeIn"
      data-wow-delay="0.1s"
    >
      <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
        <div class="col-lg-6 px-5 text-start">
          <small
            ><i class="fa fa-map-marker-alt me-2"></i>123 Street, New York,
            USA</small
          >
          <small class="ms-4"
            ><i class="fa fa-envelope me-2"></i>info@example.com</small
          >
        </div>
        <div class="col-lg-6 px-5 text-end">
          <small>Follow us:</small>
          <a class="text-body ms-3" href=""
            ><i class="fab fa-facebook-f"></i
          ></a>
          <a class="text-body ms-3" href=""><i class="fab fa-twitter"></i></a>
          <a class="text-body ms-3" href=""
            ><i class="fab fa-linkedin-in"></i
          ></a>
          <a class="text-body ms-3" href=""><i class="fab fa-instagram"></i></a>
        </div>
      </div>

      <nav
        class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn"
        data-wow-delay="0.1s"
      >
        <a href="index.html" class="navbar-brand ms-4 ms-lg-0">
          <h1 class="fw-bold text-primary m-0">
            FALLE<span class="text-secondary">7</span>A
          </h1>
        </a>
        <button
          type="button"
          class="navbar-toggler me-4"
          data-bs-toggle="collapse"
          data-bs-target="#navbarCollapse"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.html" class="nav-item nav-link">Home</a>
            <a href="product.html" class="nav-item nav-link">Products</a>
            <a href="feature.html" class="nav-item nav-link">Services</a>
            <a href="contact.html" class="nav-item nav-link">Contact Us</a>
            <a href="#" class="nav-item nav-link">About Us</a>
          </div>
          <div class="d-none d-lg-flex ms-2">
            <a class="btn-sm-square bg-white rounded-circle ms-3" href="#">
              <small class="fa fa-search text-body"></small>
            </a>
            <a class="btn-sm-square bg-white rounded-circle ms-3" href="#">
              <small class="fa fa-user text-body"></small>
            </a>
            <a class="btn-sm-square bg-white rounded-circle ms-3" href="#">
              <small class="fa fa-shopping-bag text-body"></small>
              <span id="cart-count" style="position: absolute; right: 40px; background-color: red; width: 20px; height: 20px; display: flex; justify-content: center; align-items: center; border-radius: 50%; color: #fff; top: 60%; margin-bottom:100px;">0</span>
            </a>
          </div>
        </div>
      </nav>
    </div>
    <!-- Navbar End -->
     <!-- Page Header Start -->
    <div
      class="container-fluid page-header mb-5 wow fadeIn"
      data-wow-delay="0.1s"
    >
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
    <!-- Page Header End -->
    <div style="max-width: 1200px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; 
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
                <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($order['name']); ?></td>
                <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($order['description']); ?></td>
                <td style="padding: 12px; border: 1px solid #ddd;"><?= htmlspecialchars($order['price']); ?></td>
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
                                transition: transform 0.3s;"
                                onmouseover="this.style.transform='scale(1.1)';"
                                onmouseout="this.style.transform='scale(1)';">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <div align="right">
      <form action="checkOut.php"> <button type="submit" style="padding: 6px 12px; border: none; background-color: #007bff; color: white; border-radius: 4px; cursor: pointer; transition: transform 0.3s;">
      Check Out
    </button></form>
    </div>
    
</div>
<!-- Footer Start -->
<div
      class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn"
      data-wow-delay="0.1s"
    >
      <div class="container py-5">
        <div
          class="row g-5"
          style="display: flex; justify-content: space-between"
        >
          <div class="col-lg-3 col-md-6">
            <h1 class="fw-bold text-primary mb-4">
              FALLE<span class="text-secondary">7</span>A
            </h1>
            <p>
              Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat
              ipsum et lorem et sit, sed stet lorem sit clita
            </p>
            <div class="d-flex pt-2">
              <a
                class="btn btn-square btn-outline-light rounded-circle me-1"
                href=""
                ><i class="fab fa-twitter"></i
              ></a>
              <a
                class="btn btn-square btn-outline-light rounded-circle me-1"
                href=""
                ><i class="fab fa-facebook-f"></i
              ></a>
              <a
                class="btn btn-square btn-outline-light rounded-circle me-1"
                href=""
                ><i class="fab fa-youtube"></i
              ></a>
              <a
                class="btn btn-square btn-outline-light rounded-circle me-0"
                href=""
                ><i class="fab fa-linkedin-in"></i
              ></a>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <h4 class="text-light mb-4">Address</h4>
            <p>
              <i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA
            </p>
            <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
            <p><i class="fa fa-envelope me-3"></i>info@example.com</p>
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
    <!-- Footer End -->


<script>

    function validateQuantity(input) {

        if (input.value < 1) {

            input.value = 1;
        }
    }
</script>

      <!-- Back to Top -->
      <a
      href="#"
      class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"
      ><i class="bi bi-arrow-up"></i
    ></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>


    <script>
      // AJAX to get the order count and update the cart icon
      function updateCartCount() {
          $.ajax({
              url: 'getOrderCount.php',
              type: 'GET',
              dataType: 'json',
              success: function(response) {
                  if (response.orderCount !== undefined) {
                      $('#cart-count').text(response.orderCount);
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
