<?php
require_once __DIR__ . '/../../Controller/OrderController.php';

$orderController = new OrderController();
$pdo = config::getConnexion();

if (isset($_GET['product_id'], $_GET['quantity'], $_GET['client_id'])) {
    $client_id = intval($_GET['client_id']);
    $product_id = intval($_GET['product_id']);
    $quantity = intval($_GET['quantity']);

    if ($client_id > 0 && $product_id > 0 && $quantity > 0) {
        try {
            // Prepare the query to update the "buy" column
            $query = "UPDATE products SET buy = buy + :quantity WHERE product_id = :product_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect to success page
                header("Location: product.html?status=success");
                exit;
            } else {
                // Log failure for debugging
                error_log("Failed to execute query: UPDATE products SET buy = buy + $quantity WHERE product_id = $product_id");
                header("Location: product.html?status=error");
                exit;
            }
        } catch (PDOException $e) {
            // Log error for debugging
            error_log("Database Error: " . $e->getMessage());
            header("Location: product.html?status=danger");
            exit;
        }
    } else {
        // Invalid input detected
        error_log("Invalid parameters: Client ID: $client_id, Product ID: $product_id, Quantity: $quantity");
        header("Location: product.html?status=invalid");
        exit;
    }
} else {
    // Missing parameters
    error_log("Missing required parameters.");
    header("Location: product.html?status=missing");
    exit;
}
?>
