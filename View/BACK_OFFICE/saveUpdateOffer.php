<?php

require_once '../../Controller/TravelOfferController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $offerData = 
	[
        'id' => $_POST['id'],
        'title' => $_POST['title'],
        'destination' => $_POST['destination'],
        'departure' => $_POST['departure'],
        'return' => $_POST['return'],
        'price' => (float)$_POST['price'],
        'category' => $_POST['category']
    ];
    $controller = new TravelOfferController();
    $controller->updateOffer($offerData);	
    echo "<script>
            alert('Offer updated successfully!');
            window.location.href = 'addTravelOffer.php';
          </script>";
    exit;
}
?>