<?php
include '../Controller/ProduitC.php';
$produitC = new ProduitC();

$categories = $produitC->getCategories();

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$nomCategorie = isset($_GET['categorie']) ? $_GET['categorie'] : null;

$maxPrix = isset($_GET['maxPrix']) ? (float)$_GET['maxPrix'] : 100.0;

if ($searchQuery && $nomCategorie) {
    $list = $produitC->rechercherProduits($searchQuery, $nomCategorie, $maxPrix);
} elseif ($searchQuery) {
    $list = $produitC->rechercherProduits($searchQuery, null, $maxPrix);
} elseif ($nomCategorie) {
    $list = $produitC->AfficherProduitParNomCategorie($nomCategorie, $maxPrix);
} else {
    $list = $produitC->getProduitsByPrix($maxPrix);
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
    <link href="Front_Office/css/chatbot.css" rel="stylesheet" />
    <link href="Front_Office/img/favicon.ico" rel="icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="Front_Office/lib/animate/animate.min.css" rel="stylesheet" />
    <link href="Front_Office/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="Front_Office/css/bootstrap.min.css" rel="stylesheet" />
    <link href="Front_Office/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://js.puter.com/v2/"></script>
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
                    <a href="Front_Office/index.html" class="nav-item nav-link">Home</a>
                    <a href="#" class="nav-item nav-link active">Products</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="servicesDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item" href="Front_Office/services.php">view our approved
                                    employees</a></li>
                            <li><a class="dropdown-item" href="Front_Office/service_page.php#view_services">View our
                                    services</a></li>
                            <li><a class="dropdown-item" href="Front_Office/service_page.php#service_request">Request a
                                    Service</a></li>
                            <li><a class="dropdown-item" href="Front_Office/service_page.php#history_service">View
                                    Service History</a></li>
                        </ul>
                    </div>
                    <a href="Front_Office/contact.php" class="nav-item nav-link">Contact Us</a>
                    <a href="#" class="nav-item nav-link">About Us</a>
                </div>
                <div class="d-none d-lg-flex ms-2">
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="#"><small
                            class="fa fa-search text-body"></small></a>
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="logout.php"><small
                            class="fa fa-user text-body"></small></a>
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="Front_Office/cart.html">
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
            <h1 class="display-3 mb-3 animated slideInDown">Products</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-body" href="#">Home</a></li>
                    <li class="breadcrumb-item text-dark active" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container py-6">
        <div class="container">
            <div class="row g-0 gx-5 align-items-end">
                <div class="col-lg-6">
                    <div class="section-header text-start mb-5 wow fadeInUp" data-wow-delay="0.1s"
                        style="max-width: 500px;">
                        <h1 class="display-5 mb-3">Our Products</h1>
                        <p>Our products are organic, sourced directly from the farm to ensure the highest quality
                            and
                            freshness.</p>
                        <h2>Rechercher un produit</h2>
                        <form method="GET" action="ListeProduits.php">
                            <input type="text" name="search" placeholder="Rechercher un produit..."
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                            <button type="submit">Rechercher</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s">
                    <ul class="nav nav-pills d-inline-flex justify-content-end gap-2 mb-5">
                        <?php 
                    if (!empty($categories) && is_array($categories)) {
                        foreach ($categories as $category) {
                            $categoryName = htmlspecialchars($category['Nom']); 
                            $isActive = ($nomCategorie === $category['Nom']) ? 'active' : ''; 
                            echo '<li class="nav-item">
                                <a class="btn btn-outline-primary border-2 ' . $isActive . '" 
                                href="ListeProduits.php?categorie=' . urlencode($category['Nom']) . '">' . $categoryName . '</a>
                                </li>';
                        }
                    }
                    ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary border-2 <?php echo is_null($nomCategorie) ? 'active' : ''; ?>"
                                href="ListeProduits.php">All Products</a>
                        </li>
                    </ul>
                    <form action="ListeProduits.php" method="get">
                        <div class="slider-container">
                            <label for="priceRange">Prix maximum : <span id="priceValue"><?php echo $maxPrix; ?></span>
                                DT</label>
                            <input type="range" id="priceRange" name="maxPrix" min="0" max="100" step="1"
                                value="<?php echo $maxPrix; ?>" oninput="updatePriceValue(this.value)">
                        </div>
                        <button type="submit" class="btn btn-primary">Filtrer</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <style>
                .product-item img {
                    height: 220px;
                    object-fit: cover;
                    width: 100%;
                }
                </style>
                <?php if (!empty($list)): ?>
                <div class="row">
                    <?php foreach ($list as $produit): ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="product-item">
                            <div class="position-relative bg-light overflow-hidden">
                                <?php if (!empty($produit['Image']) && is_string($produit['Image'])): ?>
                                <img class="img-fluid"
                                    src="data:image/jpeg;base64,<?php echo base64_encode($produit['Image']); ?>"
                                    alt="<?php echo htmlspecialchars($produit['Nom'] ?? 'Produit', ENT_QUOTES, 'UTF-8'); ?>">
                                <?php else: ?>
                                <img class="img-fluid" src="path/to/default/image.jpg" alt="Image not available">
                                <?php endif; ?>
                            </div>
                            <div class="text-center p-4">
                                <?php if (!empty($produit['Nom'])): ?>
                                <a class="d-block h5 mb-2"
                                    href="ViewProduct.php?id=<?php echo !empty($produit['Id_Produit']) ? urlencode($produit['Id_Produit']) : '#'; ?>">
                                    <?php echo htmlspecialchars($produit['Nom'], ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                                <?php else: ?>
                                <p>Nom non disponible</p>
                                <?php endif; ?>
                                <?php if (!empty($produit['Description'])): ?>
                                <p class="text-muted mb-2">
                                    <?php echo htmlspecialchars($produit['Description'], ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                                <button class="btn btn-outline-primary"
                                    onclick="speakDescription('<?php echo htmlspecialchars($produit['Description'], ENT_QUOTES, 'UTF-8'); ?>')">
                                    <i class="fa fa-volume-up me-2"></i> listen
                                </button>
                                <?php else: ?>
                                <p>Description non disponible</p>
                                <?php endif; ?>
                                <br>
                                <?php if (isset($produit['Prix'])): ?>
                                <span
                                    class="text-primary me-1"><?php echo number_format((float)$produit['Prix'], 2, '.', ''); ?>
                                    dt</span>
                                <?php else: ?>
                                <span class="text-danger">Prix non disponible</span>
                                <?php endif; ?>
                                <div class="rating mb-2">
                                    <input type="hidden"
                                        id="product_id_<?php echo htmlspecialchars($produit['Id_Produit'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                        value="<?php echo htmlspecialchars($produit['Id_Produit'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    <span class="star" data-value="1">&#9733;</span>
                                    <span class="star" data-value="2">&#9733;</span>
                                    <span class="star" data-value="3">&#9733;</span>
                                    <span class="star" data-value="4">&#9733;</span>
                                    <span class="star" data-value="5">&#9733;</span>
                                    <span
                                        id="rating_value_<?php echo htmlspecialchars($produit['Id_Produit'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                        class="d-block mt-2"></span>
                                </div>
                            </div>
                            <div class="d-flex border-top">
                                <small class="w-50 text-center border-end py-2">
                                    <a class="text-body"
                                        href="ViewProduct.php?id=<?php echo !empty($produit['Id_Produit']) ? urlencode($produit['Id_Produit']) : '#'; ?>">
                                        <i class="fa fa-eye text-primary me-2"></i>Voir les détails
                                    </a>
                                </small>
                                <small class="w-50 text-center py-2">
                                    <a class="btn text-body" href="#"
                                        onclick="add('<?php echo !empty($produit['Id_Produit']) ? addslashes($produit['Id_Produit']) : ''; ?>');"><i
                                            class="fa fa-shopping-bag text-primary me-2"></i>Ajouter au panier</a>
                                    <script>
                                    function add(productId) {
                                        const token = localStorage.getItem('token');
                                        const clientId = JSON.parse(atob(token.split('.')[1])).data.id;
                                        const url =
                                            `Front_Office/addProduct.php?id=${encodeURIComponent(productId)}&clientId=${encodeURIComponent(clientId)}`;
                                        window.location.href = url;
                                    }
                                    </script>
                                </small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p>Aucun produit trouvé pour ce prix.</p>
                <?php endif; ?>
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
    <script src="Front_Office/lib/wow/wow.min.js"></script>
    <script src="Front_Office/lib/easing/easing.min.js"></script>
    <script src="Front_Office/lib/waypoints/waypoints.min.js"></script>
    <script src="Front_Office/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="Front_Office/js/main.js"></script>
    <script src="Front_Office/js/chatbot.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star');
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-value');
                const Id_Produit = this.closest('.product-item').querySelector(
                    'input[type="hidden"]').value;
                updateStars(Id_Produit, rating);
                submitRating(Id_Produit, rating);
            });
            star.addEventListener('mouseover', function() {
                const rating = this.getAttribute('data-value');
                highlightStars(this.closest('.product-item').querySelector('.rating'), rating);
            });
            star.addEventListener('mouseleave', function() {
                const Id_Produit = this.closest('.product-item').querySelector(
                    'input[type="hidden"]').value;
                const rating = document.getElementById(`rating_value_${Id_Produit}`).value;
                highlightStars(this.closest('.product-item').querySelector('.rating'), rating);
            });
        });

        function updateStars(Id_Produit, rating) {
            const stars = document.querySelectorAll(`#rating_${Id_Produit} .star`);
            stars.forEach(star => {
                star.getAttribute('data-value') <= rating ? star.classList.add('filled') : star
                    .classList.remove('filled');
            });
            document.getElementById(`rating_value_${Id_Produit}`).value = rating;
            document.getElementById(`rating_value_display_${Id_Produit}`).innerHTML = `Note: ${rating} étoiles`;
        };

        function submitRating(Id_Produit, rating) {
            console.log(`Sending rating for product ${Id_Produit} with value ${rating}`);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'rateProduct.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(`Id_Produit=${encodeURIComponent(Id_Produit)}&rating=${encodeURIComponent(rating)}`);
            xhr.onload = function() {
                xhr.status === 200 ? console.log('Server response:', xhr.responseText) : console.log(
                    'Error sending rating.');
            };
        };

        function highlightStars(ratingContainer, rating) {
            const stars = ratingContainer.querySelectorAll('.star');
            stars.forEach(star => {
                star.getAttribute('data-value') <= rating ? star.classList.add('highlight') : star
                    .classList.remove('highlight');
            });
        }
    });

    function updatePriceValue(value) {
        document.getElementById('priceValue').textContent = value;
    };

    function speakDescription(text) {
        puter.ai.txt2speech(text).then(audio => {
            audio.play();
        }).catch(error => {
            console.error('Error:', error);
        });
    }
    </script>

    <style>
    .star {
        font-size: 24px;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .star.filled {
        color: #ffcc00;
    }

    .star.highlight {
        color: #ff9900;
    }
    </style>

</body>

</html>
