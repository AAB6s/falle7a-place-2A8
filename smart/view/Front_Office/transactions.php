<?php
require_once __DIR__ . '/../../Config.php';
require_once __DIR__ . '/../../vendor/autoload.php'; // Include Stripe PHP library




$pdo = Config::getConnexion();



$statusFilter = $_GET['status_filter'] ?? 'in progress';
$itemsPerPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

try {
    $stmt = $pdo->prepare("
        SELECT * 
        FROM transaction 
        WHERE status = :status 
        ORDER BY created_at DESC 
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':status', $statusFilter);
    $stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM transaction WHERE status = :status");
    $stmt->bindValue(':status', $statusFilter);
    $stmt->execute();
    $totalTransactions = $stmt->fetchColumn();
    $totalPages = ceil($totalTransactions / $itemsPerPage);
} catch (Exception $e) {
    die("Error fetching transactions: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>


    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <link href="img/favicon.ico" rel="icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap"
        rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <link href="lib/animate/animate.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <link href="css/style.css" rel="stylesheet" />
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




    <h1 style="text-align: center; color: #333;">Transaction</h1>



    <div class="status-buttons" style="text-align: center; margin: 20px 0;">
        <a href="?status_filter=in progress&page=1"
            class="status-btn <?php echo ($statusFilter === 'in progress') ? 'active' : ''; ?>"
            style="padding: 12px 25px; text-decoration: none; background-color: #007bff; color: white; margin: 0 10px; border-radius: 8px; font-weight: bold; transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s; display: inline-block;">
            In Progress
        </a>
        <a href="?status_filter=delivered&page=1"
            class="status-btn <?php echo ($statusFilter === 'delivered') ? 'active' : ''; ?>"
            style="padding: 12px 25px; text-decoration: none; background-color: #007bff; color: white; margin: 0 10px; border-radius: 8px; font-weight: bold; transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s; display: inline-block;">
            Delivered
        </a>
        <a href="?status_filter=canceled&page=1"
            class="status-btn <?php echo ($statusFilter === 'canceled') ? 'active' : ''; ?>"
            style="padding: 12px 25px; text-decoration: none; background-color: #007bff; color: white; margin: 0 10px; border-radius: 8px; font-weight: bold; transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s; display: inline-block;">
            Canceled
        </a>
    </div>

    <div class="container"
        style="max-width: 1200px; margin: 40px auto; padding: 20px; background-color: white; border-radius: 12px; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1); animation: fadeInContainer 0.8s ease-out;">
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th
                        style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd; background-color: #007bff; color: white;">
                        Full Name</th>
                    <th
                        style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd; background-color: #007bff; color: white;">
                        Phone Number</th>
                    <th
                        style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd; background-color: #007bff; color: white;">
                        Delivery Address</th>
                    <th
                        style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd; background-color: #007bff; color: white;">
                        Product Details</th>
                    <th
                        style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd; background-color: #007bff; color: white;">
                        Status</th>
                    <th
                        style="padding: 15px; text-align: left; border-bottom: 1px solid #ddd; background-color: #007bff; color: white;">
                        Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($transactions) > 0): ?>
                <?php foreach ($transactions as $transaction): ?>
                <tr style="background-color: #f9f9f9; border-bottom: 1px solid #ddd;">
                    <td style="padding: 15px;"><?= htmlspecialchars($transaction['full_name']) ?></td>
                    <td style="padding: 15px;"><?= htmlspecialchars($transaction['phone_number']) ?></td>
                    <td style="padding: 15px;"><?= htmlspecialchars($transaction['delivery_address']) ?></td>
                    <td style="padding: 15px;">
                        <?php
                        $productDetails = json_decode($transaction['product_details'], true);
                        foreach ($productDetails as $item): ?>
                        <div
                            style="font-size: 14px; background-color: #f9f9f9; padding: 10px; border-radius: 8px; margin-top: 5px;">
                            <span style="font-weight: bold;">Product:</span> <?= htmlspecialchars($item['name']) ?><br>
                            <span style="font-weight: bold;">Price:</span> <?= number_format($item['price']) ?> TND<br>
                            <span style="font-weight: bold;">Quantity:</span> <?= htmlspecialchars($item['quantity']) ?>
                        </div>
                        <?php endforeach; ?>
                    </td>
                    <td style="padding: 15px;"><?= htmlspecialchars($transaction['status']) ?></td>
                    <td style="padding: 15px;"><?= htmlspecialchars($transaction['created_at']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #888; padding: 20px; font-size: 1.2em;">No
                        transactions found for this status.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination"
        style="text-align: center; margin-top: 30px; display: flex; justify-content: center; align-items: center; gap: 10px;">
        <?php if ($page > 1): ?>
        <a href="?status_filter=<?= $statusFilter ?>&page=<?= $page - 1 ?>"
            style="padding: 10px 20px; text-decoration: none; background-color: #007bff; color: white; border-radius: 8px; font-weight: bold; transition: background-color 0.3s, transform 0.3s;">Previous</a>
        <?php endif; ?>

        <span
            style="padding: 10px 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; font-weight: bold;"><?= $page ?>
            of <?= $totalPages ?></span>

        <?php if ($page < $totalPages): ?>
        <a href="?status_filter=<?= $statusFilter ?>&page=<?= $page + 1 ?>"
            style="padding: 10px 20px; text-decoration: none; background-color: #007bff; color: white; border-radius: 8px; font-weight: bold; transition: background-color 0.3s, transform 0.3s;">Next</a>
        <?php endif; ?>
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

</html>
