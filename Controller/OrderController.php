<?php
require_once __DIR__ . '/../Model/Order.php';
require_once __DIR__ . '/../Config.php';

class OrderController
{
    // List all orders with product name, description, and quantity
    public function listOrders()
{
    try {
        $pdo = Config::getConnexion();
        $stmt = $pdo->prepare("
            SELECT o.order_id, p.product_id, p.name, p.description, p.price, o.quantity
            FROM orders o
            JOIN products p ON o.product_id = p.product_id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}


    public function getOrderCount()
    {
        try {
            $pdo = Config::getConnexion();
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM orders");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    

    // Delete an order by ID
    public function deleteOrder($id)
    {
        try {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("DELETE FROM orders WHERE order_id = :id");
            $query->execute(['id' => $id]);
            return $query->rowCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }
    
        public function updateOrderQuantity($order_id, $quantity)
    {
        try {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("
                UPDATE orders 
                SET quantity = :quantity 
                WHERE order_id = :order_id
            ");
            $query->execute([
                'quantity' => $quantity,
                'order_id' => $order_id
            ]);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function addProductToCart($client_id, $product_id, $quantity) {
        try {
            $pdo = Config::getConnexion();
            $stmt = $pdo->prepare("
                INSERT INTO `orders` (`order_id`, `client_id`, `product_id`, `quantity`, `order_date`) 
                VALUES (NULL, :client_id, :product_id, :quantity, NOW())
            ");
            $stmt->execute([
                'client_id' => $client_id,
                'product_id' => $product_id,
                'quantity' => $quantity
            ]);
            return "Product added to cart successfully!";
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

}
?>
