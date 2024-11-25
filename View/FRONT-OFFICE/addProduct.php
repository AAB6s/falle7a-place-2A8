<?php

require_once __DIR__ . '/../../Controller/OrderController.php';

$orderController = new OrderController();

if (isset($_GET['product_id']) && isset($_GET['quantity']) && isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];
    $product_id = $_GET['product_id'];
    $quantity = $_GET['quantity'];
    echo $orderController->addProductToCart($client_id, $product_id, $quantity);
    header("Location: product.html?status=success");
} else {
    header("Location: product.html?status=danger");
}
?>