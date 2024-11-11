<?php
	require_once '../../Controller/TravelOfferController.php';
	if ($_SERVER['REQUEST_METHOD'] === 'POST')
	{
		$offerData = 
		[
			'title' => $_POST['title'],
			'destination' => $_POST['destination'],
			'departure' => $_POST['departure'],
			'return' => $_POST['return'],
			'price' => (float)$_POST['price'],
			'availability' => isset($_POST['availability']) ? 1 : 0,
			'category' => $_POST['category']
		];
		$controller = new TravelOfferController();
		$controller->addOffre($offerData);
		echo "<script>
				alert('Offer added successfully!');
				window.location.href = 'addTravelOffer.php';
			  </script>";
		exit;
	}
?>