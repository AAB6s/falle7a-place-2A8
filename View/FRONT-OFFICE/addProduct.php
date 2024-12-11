<?php

require_once __DIR__ . '/../../Controller/OrderController.php';

$orderController = new OrderController();
$pdo = Config::getConnexion();

if (isset($_GET['product_id']) && isset($_GET['quantity']) && isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];
    $product_id = $_GET['product_id'];
    $quantity = $_GET['quantity'];

    // Add product to the cart
    echo $orderController->addProductToCart($client_id, $product_id, $quantity);

    // Update the "buy" column in the products table
    $query = "UPDATE products SET buy = buy + :quantity WHERE product_id = :product_id";  // Corrected column name here
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Successfully updated the "buy" column
        header("Location: product.html?status=success");
    } else {
        // Error updating the "buy" column
        header("Location: product.html?status=error");
    }
} else {
    header("Location: product.html?status=danger");
}
?>
