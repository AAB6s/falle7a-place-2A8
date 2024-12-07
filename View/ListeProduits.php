<?php
include '../Controller/ProduitC.php';
$produitC = new ProduitC();

// Get the categories from the database
$categories = $produitC->getCategories();

// Get the search query from the URL query parameter
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
echo "Search Query: " . htmlspecialchars($searchQuery);

// Get the selected category from the URL query parameter
$nomCategorie = isset($_GET['categorie']) ? $_GET['categorie'] : null;

// Get the maximum price from the form (default: 100 if not set)
$maxPrix = isset($_GET['maxPrix']) ? (float)$_GET['maxPrix'] : 100.0;

if ($searchQuery && $nomCategorie) {
    // Search by both query and category
    $list = $produitC->rechercherProduits($searchQuery, $nomCategorie, $maxPrix);
} elseif ($searchQuery) {
    // Search only by query
    $list = $produitC->rechercherProduits($searchQuery, null, $maxPrix);
} elseif ($nomCategorie) {
    // Filter by category and price
    $list = $produitC->AfficherProduitParNomCategorie($nomCategorie, $maxPrix);
} else {
    // Show all products filtered by price
    $list = $produitC->getProduitsByPrix($maxPrix);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Falleha Place</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="FRONT-OFFICE/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="FRONT-OFFICE/lib/animate/animate.min.css" rel="stylesheet">
    <link href="FRONT-OFFICE/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="FRONT-OFFICE/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="FRONT-OFFICE/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .slider-container {
            width: 80%;
            margin: 20px auto;
        }
        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .product {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            width: 200px;
            text-align: center;
        }
        .product img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    
    <!-- Navbar Start -->
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <!-- Add your Navbar code here -->
    </div>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <h1 class="display-3 mb-3 animated slideInDown">Products</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-body" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-body" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-dark active" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

   <!-- Product Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-0 gx-5 align-items-end">
            <div class="col-lg-6">
                <div class="section-header text-start mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                    <h1 class="display-5 mb-3">Our Products</h1>
                    <p>Our products are organic, sourced directly from the farm to ensure the highest quality and freshness.</p>
                    
                    <h2>Rechercher un produit</h2>
                    <form method="GET" action="ListeProduits.php">
    <input type="text" name="search" placeholder="Rechercher un produit..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
    <button type="submit">Rechercher</button>
</form>


                </div>
            </div>
            <div class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s">
            <ul class="nav nav-pills d-inline-flex justify-content-end gap-2 mb-5">


        
       
            
            
    <?php 
    
    
    // Ensure $categories is defined and not empty before looping
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

<!-- Formulaire de filtrage par prix -->
<form action="ListeProduits.php" method="get">
    <div class="slider-container">
        <!-- Étiquette pour le prix maximum sélectionné -->
        <label for="priceRange">Prix maximum : <span id="priceValue"><?php echo $maxPrix; ?></span> DT</label>

        <!-- Slider pour le prix (min: 0, max: 100) -->
        <input type="range" id="priceRange" name="maxPrix" min="0" max="100" step="1" value="<?php echo $maxPrix; ?>" oninput="updatePriceValue(this.value)">
    </div>

    <!-- Bouton pour appliquer le filtrage -->
    <button type="submit" class="btn btn-primary">Filtrer</button>
</form>

<script>
    // Fonction pour mettre à jour l'affichage de la valeur du prix lorsque l'utilisateur déplace le slider
    function updatePriceValue(value) {
        document.getElementById('priceValue').textContent = value;
    }
</script>

<div id="productsContainer"></div>
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

<!-- Affichage des produits filtrés par prix -->
<?php if (!empty($list)): ?>
    <div class="row">
        <?php foreach ($list as $produit): ?>
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="product-item">
                    <div class="position-relative bg-light overflow-hidden">
                        <?php if (!empty($produit['Image']) && is_string($produit['Image'])): ?>
                            <img class="img-fluid" src="data:image/jpeg;base64,<?php echo base64_encode($produit['Image']); ?>" alt="<?php echo htmlspecialchars($produit['Nom'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php else: ?>
                            <img class="img-fluid" src="path/to/default/image.jpg" alt="Image not available">
                        <?php endif; ?>
                    </div>
                    <div class="text-center p-4">
                        <?php if (isset($produit['Nom']) && !empty($produit['Nom'])): ?>
                            <a class="d-block h5 mb-2" href="ViewProduct.php?id=<?php echo isset($produit['id_Produit']) ? urlencode($produit['id_Produit']) : '#'; ?>">
                                <?php echo htmlspecialchars($produit['Nom'], ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        <?php else: ?>
                            <p>Nom non disponible</p>
                        <?php endif; ?>

                        <?php if (!empty($produit['Description'])): ?>
                            <p class="text-muted mb-2"><?php echo htmlspecialchars($produit['Description'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <?php else: ?>
                            <p>Description non disponible</p>
                        <?php endif; ?>

                        <?php if (isset($produit['Prix'])): ?>
                            <span class="text-primary me-1"><?php echo number_format((float)$produit['Prix'], 2, '.', ''); ?> dt</span>
                        <?php else: ?>
                            <span class="text-danger">Prix non disponible</span>
                        <?php endif; ?>

                        <!-- Affichage des étoiles de notation interactives -->
                        <div class="rating mb-2">
                            <?php if (isset($produit['id_Produit'])): ?>
                                <input type="hidden" id="product_id_<?php echo $produit['id_Produit']; ?>" value="<?php echo $produit['id_Produit']; ?>">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                                <span id="rating_value_<?php echo $produit['id_Produit']; ?>" class="d-block mt-2"></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="d-flex border-top">
                        <small class="w-50 text-center border-end py-2">
                            <a class="text-body" href="ViewProduct.php?id=<?php echo isset($produit['id_Produit']) ? urlencode($produit['id_Produit']) : '#'; ?>">
                                <i class="fa fa-eye text-primary me-2"></i>Voir les détails
                            </a>
                        </small>
                        <small class="w-50 text-center py-2">
                            <a class="text-body" href="AddToCart.php?id=<?php echo isset($produit['id_Produit']) ? urlencode($produit['id_Produit']) : '#'; ?>">
                                <i class="fa fa-shopping-bag text-primary me-2"></i>Ajouter au panier
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Aucun produit trouvé pour ce prix.</p>
<?php endif; ?>
<!-- Product End -->







                       


    <!-- Firm Visit Start -->
    <div class="container-fluid bg-primary bg-icon mt-5 py-6">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-md-7 wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="display-5 text-white mb-3">Visit Our Firm</h1>
                    <p class="text-white mb-0">Visit our farm to experience fresh, organic products and meet our free-range animals. Enjoy the best of sustainable farming!</p>
                </div>
                <div class="col-md-5 text-md-end wow fadeIn" data-wow-delay="0.5s">
                    <a class="btn btn-lg btn-secondary rounded-pill py-3 px-5" href="">Visit Now</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Firm Visit End -->


    <!-- Testimonial Start -->
    <div class="container-fluid bg-light bg-icon py-6">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-5 mb-3">Customer Review</h1>
                
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <i class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"></i>
                    <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="img/testimonial-1.jpg" alt="">
                        <div class="ms-3">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <i class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"></i>
                    <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="img/testimonial-2.jpg" alt="">
                        <div class="ms-3">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <i class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"></i>
                    <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="img/testimonial-3.jpg" alt="">
                        <div class="ms-3">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item position-relative bg-white p-5 mt-4">
                    <i class="fa fa-quote-left fa-3x text-primary position-absolute top-0 start-0 mt-n4 ms-5"></i>
                    <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="img/testimonial-4.jpg" alt="">
                        <div class="ms-3">
                            <h5 class="mb-1">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


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


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="FRONT-OFFICE/lib/wow/wow.min.js"></script>
    <script src="FRONT-OFFICE/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="FRONT-OFFICE/js/bootstrap.bundle.min.js"></script>
    <script src="FRONT-OFFICE/js/main.js"></script>

    <!-- Template Javascript -->
    <script src="FRONT-OFFICE/js/main.js"></script>
    


    <script>
   document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-value'); // Récupérer la valeur de la note
            const Id_Produit = this.closest('.product-item').querySelector('input[type="hidden"]').value; // Utiliser Id_Produit

            // Mettre à jour les étoiles affichées
            updateStars(Id_Produit, rating);

            // Envoi de la note au serveur via AJAX
            submitRating(Id_Produit, rating);
        });

        // Survol des étoiles
        star.addEventListener('mouseover', function() {
            const rating = this.getAttribute('data-value');
            highlightStars(this.closest('.product-item').querySelector('.rating'), rating);
        });

        // Réinitialisation après survol
        star.addEventListener('mouseleave', function() {
            const Id_Produit = this.closest('.product-item').querySelector('input[type="hidden"]').value; // Utiliser Id_Produit
            const rating = document.getElementById(`rating_value_${Id_Produit}`).value;
            highlightStars(this.closest('.product-item').querySelector('.rating'), rating);
        });
    });

    function updateStars(Id_Produit, rating) {
        const stars = document.querySelectorAll(`#rating_${Id_Produit} .star`);
        stars.forEach(star => {
            if (star.getAttribute('data-value') <= rating) {
                star.classList.add('filled');
            } else {
                star.classList.remove('filled');
            }
        });

        // Mettre à jour la note dans le champ caché et l'afficher
        document.getElementById(`rating_value_${Id_Produit}`).value = rating;
        document.getElementById(`rating_value_display_${Id_Produit}`).innerHTML = `Note: ${rating} étoiles`;
    }

    function submitRating(Id_Produit, rating) {
    console.log(`Envoi de la note pour le produit ${Id_Produit} avec la valeur ${rating}`);  // Vérifiez les données envoyées

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'rateProduct.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(`Id_Produit=${encodeURIComponent(Id_Produit)}&rating=${encodeURIComponent(rating)}`);

    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Réponse du serveur :', xhr.responseText);
        } else {
            console.log('Erreur lors de l\'envoi de la note.');
        }
    };
}

    function highlightStars(ratingContainer, rating) {
        const stars = ratingContainer.querySelectorAll('.star');
        stars.forEach(star => {
            if (star.getAttribute('data-value') <= rating) {
                star.classList.add('highlight');
            } else {
                star.classList.remove('highlight');
            }
        });
    }
});


</script>

<style>
.star {
    font-size: 24px; /* Taille des étoiles */
    color: #ddd; /* Couleur par défaut (gris) */
    cursor: pointer;
    transition: color 0.2s ease; /* Transition douce */
}

.star.filled {
    color: #ffcc00; /* Couleur des étoiles sélectionnées (jaune) */
}

.star.highlight {
    color: #ff9900; /* Couleur des étoiles lors du survol (orange clair) */
}
</style>

</body>

</html>