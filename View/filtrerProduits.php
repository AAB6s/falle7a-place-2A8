<?php
// Récupérer le prix maximum depuis le formulaire si défini
$maxPrix = isset($_GET['maxPrix']) ? (float)$_GET['maxPrix'] : 100.0; // Par défaut, prix max à 100

// Appel de la méthode pour obtenir les produits filtrés par prix
// Supposons que vous avez une fonction `getProduitsByPrix()` dans votre contrôleur ProduitC
$produitC = new ProduitC();
$list = $produitC->getProduitsByPrix($maxPrix);
?>

<!-- Formulaire pour filtrer par prix -->
<form action="ListeProduits.php" method="get">
    <div class="slider-container">
        <label for="priceRange">Prix maximum : <span id="priceValue"><?php echo $maxPrix; ?></span> DT</label>
        <input type="range" id="priceRange" name="maxPrix" min="0" max="100" step="1" value="<?php echo $maxPrix; ?>" oninput="updatePriceValue(this.value)">
    </div>
    <button type="submit" class="btn btn-primary">Filtrer</button>
</form>

<!-- Affichage des produits -->
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
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Aucun produit trouvé pour ce prix.</p>
<?php endif; ?>

<script>
    // Met à jour la valeur du prix affiché
    function updatePriceValue(value) {
        document.getElementById('priceValue').textContent = value;
    }
</script>
