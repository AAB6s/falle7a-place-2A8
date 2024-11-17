<?php
require_once __DIR__ . '/../../Controller/OrderController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderController = new OrderController();
    
    // Get the order ID
    $order_id = $_POST['order_id'];

    // Call deleteOrder method from OrderController
    $deleted = $orderController->deleteOrder($order_id);

    // Redirect back with success or failure message
    if ($deleted) {
        header("Location: FrontEndCart.php?status=success&message=Order deleted successfully.");
    } else {
        header("Location: FrontEndCart.php?status=danger&message=Failed to delete the order.");
    }
    exit;
}
?>
