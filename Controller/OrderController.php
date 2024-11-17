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


    // Add a new order
    public function addOrder($order)
    {
        try {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("
                INSERT INTO orders (product_id, quantity, order_date) 
                VALUES (:product_id, :quantity, :order_date)
            ");
            $query->execute([
                'product_id' => $order->getProductId(),
                'quantity' => $order->getQuantity(),
                'order_date' => $order->getOrderDate()
            ]);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Add this function to OrderController.php

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

    // Get an order by ID
    public function getOrderById($id)
    {
        try {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("
                SELECT o.order_id, o.product_id, o.quantity, o.order_date, p.name as product_name
                FROM orders o
                JOIN products p ON o.product_id = p.product_id
                WHERE o.order_id = :id
            ");
            $query->execute(['id' => $id]);
            return $query->fetch();
        } catch (Exception $e) {
            return null;
        }
    }

            // Update an existing order
            public function updateOrder($order_id, $product_id, $quantity, $order_date)
        {
            try {
                $pdo = Config::getConnexion();
                $query = $pdo->prepare("
                    UPDATE orders 
                    SET product_id = :product_id, quantity = :quantity, order_date = :order_date
                    WHERE order_id = :order_id
                ");
                $query->execute([
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'order_date' => $order_date,
                    'order_id' => $order_id
                ]);
            } catch (Exception $e) {
                die('Error: ' . $e->getMessage());
            }
        }

    // Update order quantity by ID (used for increment/decrement functionality)
    
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

}
?>
