<?php 

	include_once("../../Model/TravelOffer.php");
	include_once("../../Controller/TravelOfferController.php");

	$travelOffer=new TravelOffer($_POST["title"],$_POST["destination"],new DateTime($_POST["departure"]),new DateTime($_POST["return"]),(float)$_POST["price"],isset($_POST["availability"]),$_POST["category"]);

	$controller=new TravelOfferController();
	$controller->showTravelOffer($travelOffer);
	
?>