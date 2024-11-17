<?php
require_once __DIR__ . '/../../Controller/OrderController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderController = new OrderController();

    // Retrieve order ID and action (increment/decrement)
    $order_id = $_POST['order_id'];
    $quantity = $_POST['quantity']; // Current quantity
    $action = $_POST['action'];

    // Modify the quantity based on the action
    if ($action === 'increment') {
        $quantity++;
    } elseif ($action === 'decrement' && $quantity > 1) {
        $quantity--;
    }

    // Update the order in the database
    $orderController->updateOrderQuantity($order_id, $quantity);

    // Redirect back to the cart page with a success message
    header("Location: FrontEndCart.php?status=success&message=Quantity updated successfully.");
    exit;
}
?>
