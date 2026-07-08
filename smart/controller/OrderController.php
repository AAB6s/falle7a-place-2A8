<?php
require_once __DIR__ . '/../Model/Order.php';
require_once __DIR__ . '/../config.php';

class OrderController
{
    // List all orders with product name, description, and quantity
    public function listOrders($client_id = null)
    {
        try {
            $pdo = config::getConnexion();
            $sql = "
                SELECT o.order_id, p.Id_Produit, p.Nom, p.Description, p.Prix, o.quantity
                FROM orders o
                JOIN produit p ON o.Id_Produit = p.Id_Produit
                WHERE :client_id IS NULL OR o.id = :client_id
            ";
    
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':client_id', $client_id, PDO::PARAM_INT);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    

public function listTopPurchasedProducts()
{
    try {
        // Get the database connection
        $pdo = config::getConnexion();

        // Query to get the top 5 most purchased products, ordered by the "buy" column
        $stmt = $pdo->prepare("
            SELECT p.Id_Produit, p.Nom, p.Prix, p.Image, p.buy
            FROM produit p
            ORDER BY p.buy DESC
            LIMIT 5
        ");

        // Execute the query
        $stmt->execute();

        // Fetch all the results and return them as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        // In case of an error, display the error message
        die('Error: ' . $e->getMessage());
    }
}



    public function getOrderCount()
    {
        try {
            $pdo = config::getConnexion();
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
            $pdo = config::getConnexion();
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
            $pdo = config::getConnexion();
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
    public function addProductToCart($client_id, $Id_Produit, $quantity) {
        try {
            $pdo = config::getConnexion();
            $stmt = $pdo->prepare("
                INSERT INTO `orders` (`order_id`, `id`, `Id_Produit`, `quantity`, `order_date`) 
                VALUES (NULL, :id, :Id_Produit, :quantity, NOW())
            ");
            $stmt->execute([
                'id' => $client_id,
                'Id_Produit' => $Id_Produit,
                'quantity' => $quantity
            ]);
            return "Product added to cart successfully!";
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

}
?>