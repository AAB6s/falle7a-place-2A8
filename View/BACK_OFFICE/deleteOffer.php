<?php
	require_once '../../Controller/TravelOfferController.php';
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$offerId = $_POST['id'];
		$controller = new TravelOfferController();
		$result = $controller->deleteOffer($offerId);    
		$message = $result ? "Offer deleted successfully." : "Offer not found.";
		echo "<script>
				alert('" . addslashes($message) . "');
				window.location.href = 'addTravelOffer.php';
			  </script>";
		exit;
	}
?>