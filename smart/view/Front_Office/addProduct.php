<?php

require_once __DIR__ . '/../../Controller/OrderController.php';

$orderController = new OrderController();
$id = $_GET['clientId'];
$Id_Produit = $_GET['id'];
echo $orderController->addProductToCart($id, $Id_Produit,1);
header("Location: ../ListeProduits.php"); 

?>