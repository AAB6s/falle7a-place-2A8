<?php


require_once __DIR__ . '/../../Config.php';

        
    $pdo = Config::getConnexion();
    $stmt = $pdo->prepare("INSERT INTO `orders` (`order_id`, `client_id`, `product_id`, `quantity`, `order_date`) VALUES (NULL, '1', '1', '70', '2024-11-23 20:03:35')");
    $stmt->execute();
        
    

?>