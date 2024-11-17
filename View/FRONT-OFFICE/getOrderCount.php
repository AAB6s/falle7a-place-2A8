<?php
// getOrderCount.php
require_once __DIR__ . '/../../Controller/OrderController.php'; // Adjust path as necessary

$orderController = new OrderController();
$orderCount = $orderController->getOrderCount(); // Assuming this method gets the order count

// Check if the order count is being fetched correctly
if ($orderCount !== false) {
    echo json_encode(['orderCount' => $orderCount]);
} else {
    echo json_encode(['orderCount' => 0]);  // Return 0 if no orders are found
}
?>
