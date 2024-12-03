<?php
require_once __DIR__ . '/../../Config.php';
require __DIR__ . '/../../vendor/autoload.php'; // For PHPMailer

$pdo = Config::getConnexion();

// Fetch user information (replace with actual logic if user data is dynamic)
$user = [
    'full_name' => 'John Doe',
    'phone_number' => '12345678',
    'delivery_address' => '123 Main Street'
];

// Generate a unique order token for verification
$orderToken = bin2hex(random_bytes(16));

// Fetch current orders from the database
$stmt = $pdo->prepare("SELECT o.product_id, o.quantity, p.name, p.price 
                       FROM orders o 
                       JOIN products p ON o.product_id = p.product_id");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = []; // Initialize an array to store validation errors
$paymentError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentMethod = $_POST['payment_method'];

    // Update user information
    $user['full_name'] = $_POST['full_name'];
    $user['phone_number'] = $_POST['phone_number'];
    $user['delivery_address'] = $_POST['delivery_address'];

    // Validate user information
    if (empty($user['full_name'])) {
        $errors['full_name'] = 'Full Name is required.';
    }
    if (empty($user['phone_number']) || !is_numeric($user['phone_number']) || strlen($user['phone_number']) < 8) {
        $errors['phone_number'] = 'Please enter a valid phone number (at least 8 digits).';
    }
    if (empty($user['delivery_address'])) {
        $errors['delivery_address'] = 'Delivery Address is required.';
    }

    if (empty($errors)) {
        $totalPrice = 0;
        $productDetails = [];
        foreach ($orders as $order) {
            $productDetails[] = [
                'product_id' => $order['product_id'],
                'name' => $order['name'],
                'price' => $order['price'],
                'quantity' => $order['quantity'],
            ];
            $totalPrice += $order['price'] * $order['quantity'];
        }

        // If Online Payment is selected, validate card details
        if ($paymentMethod === 'online') {
            $cardNumber = $_POST['card_number'];
            $expiryDate = $_POST['expiry_date'];
            $cvv = $_POST['cvv'];

            $cardNumberRegex = "/^[0-9]{16}$/";
            $expiryDateRegex = "/^(0[1-9]|1[0-2])\/\d{2}$/";
            $cvvRegex = "/^[0-9]{3}$/";

            if (!preg_match($cardNumberRegex, $cardNumber)) {
                $paymentError = "Invalid card number.";
            } elseif (!preg_match($expiryDateRegex, $expiryDate)) {
                $paymentError = "Invalid expiry date. Use MM/YY format.";
            } elseif (!preg_match($cvvRegex, $cvv)) {
                $paymentError = "Invalid CVV.";
            }
        }

        // If no payment error, process the transaction
        if (empty($paymentError)) {
            // Insert transaction into the database
            $status = 'in progress';
            $stmt = $pdo->prepare("
                INSERT INTO transaction 
                (full_name, phone_number, delivery_address, product_details, status, order_token) 
                VALUES 
                (:full_name, :phone_number, :delivery_address, :product_details, :status, :order_token)
            ");
            $stmt->execute([
                ':full_name' => $user['full_name'],
                ':phone_number' => $user['phone_number'],
                ':delivery_address' => $user['delivery_address'],
                ':product_details' => json_encode($productDetails),
                ':status' => $status,
                ':order_token' => $orderToken, // Save token to the database
            ]);

            // Send confirmation email for online payments
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Set SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'mehdialkanas@gmail.com'; // SMTP username
                $mail->Password = ''; // SMTP password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('mehdialkanas@gmail.com', 'Falle7a');
                $mail->addAddress('mahdouchtennis@gmail.com'); // Static recipient email

                $mail->isHTML(true);
                $mail->Subject = 'Order Confirmation';
                $mail->Body = "
                    <!DOCTYPE html>
                    <html>
                    <body style='font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0;'>
                        <div style='max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); overflow: hidden; border: 1px solid #eaeaea;'>
                            <div style='background-color: #4CAF50; color: #ffffff; padding: 20px; text-align: center;'>
                                <h1>Order Confirmation</h1>
                            </div>
                            <div style='padding: 20px; color: #333333;'>
                                <p>Dear <strong>" . htmlspecialchars($user['full_name']) . "</strong>,</p>
                                <p>Thank you for placing your order with us! Here are the details of your purchase:</p>
                                <table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>
                                    <thead>
                                        <tr>
                                            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Product Name</th>
                                            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Quantity</th>
                                            <th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                                    foreach ($orders as $order) {
                                        $mail->Body .= "
                                            <tr>
                                                <td style='border: 1px solid #ddd; padding: 10px;'>" . htmlspecialchars($order['name']) . "</td>
                                                <td style='border: 1px solid #ddd; padding: 10px; text-align: center;'>" . htmlspecialchars($order['quantity']) . "</td>
                                                <td style='border: 1px solid #ddd; padding: 10px; text-align: right;'>" . number_format($order['price'], 2) . " TND</td>
                                            </tr>";
                                    }
                $mail->Body .= "
                                    </tbody>
                                </table>
                                <p style='margin-top: 20px;'><strong>Total Price:</strong> " . number_format($totalPrice) . " TND</p>
                                <p>We will notify you once your order is shipped.</p>
                                <p>Best regards,</p>
                                <p>Your Store Team</p>
                            </div>
                            <div style='background-color: #f1f1f1; color: #888888; padding: 10px; text-align: center; font-size: 12px;'>
                                &copy; " . date('Y') . " Falle7a. All rights reserved.
                            </div>
                        </div>
                    </body>
                    </html>";
                $mail->send();
            } catch (Exception $e) {
                die('Email could not be sent. Mailer Error: ' . $mail->ErrorInfo);
            }

            // Clear the orders table (if necessary)
            $pdo->prepare("DELETE FROM orders")->execute();

            // Redirect to transactions page
            header("Location: transactions.php");
            exit;
        }
    }
}
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
  </head>

  <body>
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


<!-- Checkout Form -->
<div class="wow fadeInUp" data-wow-delay="0.1s" style="max-width: 1200px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
    <h1 style="color: #333; text-align: center;">Complete Your Transaction</h1>
    <form method="POST" id="checkoutForm" style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9;">
        <!-- Full Name -->
        <div style="margin-bottom: 15px;">
            <label for="full_name" style="display: block; font-weight: bold; margin-bottom: 5px;">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <div id="full_name_error" class="error" style="color: red; display: none;"></div>
        </div>

        <!-- Phone Number -->
        <div style="margin-bottom: 15px;">
            <label for="phone_number" style="display: block; font-weight: bold; margin-bottom: 5px;">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <div id="phone_number_error" class="error" style="color: red; display: none;"></div>
        </div>

        <!-- Delivery Address -->
        <div style="margin-bottom: 15px;">
            <label for="delivery_address" style="display: block; font-weight: bold; margin-bottom: 5px;">Delivery Address</label>
            <textarea id="delivery_address" name="delivery_address" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"><?php echo htmlspecialchars($user['delivery_address']); ?></textarea>
            <div id="delivery_address_error" class="error" style="color: red; display: none;"></div>
        </div>

        <!-- Products in Cart -->
        <?php $totalPrice = 0; ?>
        <h2 style="color: #555;">Products in Cart</h2>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #f1f1f1;">
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left;">Product Name</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: center;">Quantity</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: right;">Price (TND)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 10px;"><?php echo htmlspecialchars($order['name']); ?></td>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: center;"><?php echo $order['quantity']; ?></td>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: right;"><?php echo number_format($order['price'], 2); ?> TND</td>
                        <?php $totalPrice += $order['price'] * $order['quantity']; ?>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: right;"><b>Total :</b><?php echo number_format($totalPrice) ?> TND</td>
                </tr>
            </tbody>
        </table>

        <!-- Payment Method Dropdown -->
        <div style="margin-bottom: 15px;">
            <label for="payment_method" style="font-weight: bold;">Payment Method</label>
            <select id="payment_method" name="payment_method" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="hand">Hand-to-Hand Payment</option>
                <option value="online">Online Payment</option>
            </select>
        </div>

        <!-- Online Payment Fields -->
        <div id="onlinePaymentFields" style="display: none; margin-bottom: 15px;">
            <label for="card_number" style="font-weight: bold;">Card Number</label>
            <input type="text" id="card_number" name="card_number" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <div id="card_number_error" class="error" style="color: red; display: none;"></div>

            <label for="expiry_date" style="font-weight: bold;">Expiry Date (MM/YY)</label>
            <input type="text" id="expiry_date" name="expiry_date" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <div id="expiry_date_error" class="error" style="color: red; display: none;"></div>

            <label for="cvv" style="font-weight: bold;">CVV</label>
            <input type="text" id="cvv" name="cvv" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <div id="cvv_error" class="error" style="color: red; display: none;"></div>
        </div>

        <button id="completeOrderBTN"type="submit" style="width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">Complete Order</button>
    </form>
</div>

<!-- Reviews Start -->
<div class="container-xxl py-5">
      <div class="container">
        <div
          class="section-header text-center mx-auto mb-5 wow fadeInUp"
          data-wow-delay="0.1s"
          style="max-width: 500px"
        >
          <h1 class="display-5 mb-3">Customer Review</h1>
          <p>See what our clients have to say about our services.</p>
        </div>
        <div
          class="owl-carousel testimonial-carousel wow fadeInUp"
          data-wow-delay="0.1s"
        >
          <div class="testimonial-item position-relative bg-white p-5 mt-4">
            <i
              class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"
            ></i>
            <p class="mb-4">
              The service was exceptional and the team was very professional.
              Highly recommended!
            </p>
            <div class="d-flex align-items-center">
              <img
                class="flex-shrink-0 rounded-circle"
                src="img/testimonial-1.jpg"
                alt="Client Image"
              />
              <div class="ms-3">
                <h5 class="mb-1">John Doe</h5>
                <span>Project Manager</span>
              </div>
            </div>
          </div>
          <div class="testimonial-item position-relative bg-white p-5 mt-4">
            <i
              class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"
            ></i>
            <p class="mb-4">
              Amazing experience! I’m very pleased with the service provided.
            </p>
            <div class="d-flex align-items-center">
              <img
                class="flex-shrink-0 rounded-circle"
                src="img/testimonial-2.jpg"
                alt="Client Image"
              />
              <div class="ms-3">
                <h5 class="mb-1">Sarah Lee</h5>
                <span>Entrepreneur</span>
              </div>
            </div>
          </div>
          <div class="testimonial-item position-relative bg-white p-5 mt-4">
            <i
              class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"
            ></i>
            <p class="mb-4">
              I will definitely be using their services again in the future.
            </p>
            <div class="d-flex align-items-center">
              <img
                class="flex-shrink-0 rounded-circle"
                src="img/testimonial-3.jpg"
                alt="Client Image"
              />
              <div class="ms-3">
                <h5 class="mb-1">Michael Smith</h5>
                <span>Freelancer</span>
              </div>
            </div>
          </div>
          <div class="testimonial-item position-relative bg-white p-5 mt-4">
            <i
              class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"
            ></i>
            <p class="mb-4">
              The team was highly responsive and catered to all my requirements.
            </p>
            <div class="d-flex align-items-center">
              <img
                class="flex-shrink-0 rounded-circle"
                src="img/testimonial-4.jpg"
                alt="Client Image"
              />
              <div class="ms-3">
                <h5 class="mb-1">Emma Johnson</h5>
                <span>Software Engineer</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Reviews End -->

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
              Falle7a is good
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
              url: 'getOrderCount.php',  // Adjust path as needed
              type: 'GET',
              dataType: 'json',
              success: function(response) {
                if (response.orderCount !== undefined) {
                    $('#cart-count').text(response.orderCount);
                    
                    // Disable the checkout button if orderCount is less than 1
                    if (response.orderCount < 1) {
                        $('#completeOrderBTN').prop('disabled', true).css({
                            'background-color': '#ccc',
                            'cursor': 'not-allowed'
                        });
                    } else {
                        $('#completeOrderBTN').prop('disabled', false).css({
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

      // Call the function to update the cart count when the page loads
      $(document).ready(function() {
          updateCartCount();
      });
  </script>

    <!-- JavaScript for Showing/Validating Online Payment Fields -->
<script>
   document.getElementById('payment_method').addEventListener('change', function () {
    const paymentMethod = this.value;
    const onlinePaymentFields = document.getElementById('onlinePaymentFields');
    if (paymentMethod === 'online') {
        onlinePaymentFields.style.display = 'block';
    } else {
        onlinePaymentFields.style.display = 'none';
    }
});

document.getElementById('checkoutForm').addEventListener('submit', function (e) {
    let valid = true;

    // Reset all error messages
    document.querySelectorAll('.error').forEach(function (errorElement) {
        errorElement.style.display = 'none';
    });

    // Full Name validation
    const fullName = document.getElementById('full_name').value;
    if (!fullName) {
        document.getElementById('full_name_error').textContent = 'Full Name is required.';
        document.getElementById('full_name_error').style.display = 'block';
        valid = false;
    }

    // Phone Number validation
    const phoneNumber = document.getElementById('phone_number').value;
    const phoneRegex = /^[0-9]{8}$/;
    if (!phoneNumber || !phoneRegex.test(phoneNumber)) {
        document.getElementById('phone_number_error').textContent = 'Invalid phone number. Must be 8 digits.';
        document.getElementById('phone_number_error').style.display = 'block';
        valid = false;
    }

    // Delivery Address validation
    const deliveryAddress = document.getElementById('delivery_address').value;
    if (!deliveryAddress) {
        document.getElementById('delivery_address_error').textContent = 'Delivery Address is required.';
        document.getElementById('delivery_address_error').style.display = 'block';
        valid = false;
    }

    // Online Payment validation
    if (document.getElementById('payment_method').value === 'online') {
        const cardNumber = document.getElementById('card_number').value;
        const expiryDate = document.getElementById('expiry_date').value;
        const cvv = document.getElementById('cvv').value;

        const cardRegex = /^[0-9]{16}$/;
        const expiryRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
        const cvvRegex = /^[0-9]{3}$/;

        if (!cardNumber || !cardRegex.test(cardNumber)) {
            document.getElementById('card_number_error').textContent = 'Invalid card number. Must be 16 digits.';
            document.getElementById('card_number_error').style.display = 'block';
            valid = false;
        }
        if (!expiryDate || !expiryRegex.test(expiryDate)) {
            document.getElementById('expiry_date_error').textContent = 'Invalid expiry date. Format should be MM/YY.';
            document.getElementById('expiry_date_error').style.display = 'block';
            valid = false;
        }
        if (!cvv || !cvvRegex.test(cvv)) {
            document.getElementById('cvv_error').textContent = 'Invalid CVV. Must be 3 digits.';
            document.getElementById('cvv_error').style.display = 'block';
            valid = false;
        }
    }

    // If not valid, prevent form submission
    if (!valid) {
        e.preventDefault();
    }
});

</script>

   




    
  </body>
</html>




