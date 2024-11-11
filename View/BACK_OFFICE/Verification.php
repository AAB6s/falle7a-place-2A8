<?php

	require_once '../../Controller/TravelOfferController.php';

	$offer=new TravelOffer($_POST['title'],$_POST['destination'],new DateTime($_POST['departure']),new DateTime($_POST['return']),(float)$_POST['price'],isset($_POST['availability'])?true:false,$_POST['category']);

	echo "<br><br>";

	var_dump($offer);

	$controller=new TravelOfferController();
	echo "<h2>Offer Details with showTravelOffer</h2>";
	$controller->showTravelOffer($offer);

?>