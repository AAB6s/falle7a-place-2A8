<?php

    require_once __DIR__ . '/../Model/TravelOffer.php';
    require_once __DIR__ . '/../Config.php';
	
    class TravelOfferController 
    {
		public function showTravelOffers($offers) 
		{
			if (empty($offers)) 
			{
				echo "<p class='no-offers-message'>No travel offers available at the moment.</p>";
				return;
			}
			echo "<table class='travel-offers-table'>";
			echo "<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Destination</th>
					<th>Departure</th>
					<th>Return</th>
					<th>Price</th>
					<th>Availability</th>
					<th>Category</th>
				  </tr>";
			foreach ($offers as $offer) 
			{
				echo "<tr>
						<td>" . htmlspecialchars($offer['id']) . "</td>
						<td>" . htmlspecialchars($offer['title']) . "</td>
						<td>" . htmlspecialchars($offer['destination']) . "</td>
						<td>" . htmlspecialchars($offer['departure']) . "</td>
						<td>" . htmlspecialchars($offer['return']) . "</td>
						<td>$" . number_format($offer['price'], 2) . "</td>
						<td>" . ($offer['availability'] ? "Available" : "Not Available") . "</td>
						<td>" . htmlspecialchars($offer['category']) . "</td>
					  </tr>";
			}
			echo "</table>";
		}		
        public function listOffers()
        {
            try 
            {
                $pdo = config::getConnexion();
                $stmt = $pdo->prepare("SELECT * FROM TravelOffer");
                $stmt->execute();
                $offers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $offers;
            } 
            catch (Exception $e) 
            {
                die('Error: ' . $e->getMessage());
            }
        }
		public function addOffre($offer) 
		{
			try 
			{
				$pdo = config::getConnexion();
				$query = $pdo->prepare("INSERT INTO TravelOffer (title, destination, departure, `return`, price, availability, category) 
										VALUES (:title, :destination, :departure, :return, :price, :availability, :category)");
				$query->execute([
					'title' => $offer['title'],
					'destination' => $offer['destination'],
					'departure' => $offer['departure'],
					'return' => $offer['return'],
					'price' => $offer['price'],
					'availability' => $offer['availability'],
					'category' => $offer['category']
				]);
			}
			catch (Exception $e) 
			{
				die('Error: ' . $e->getMessage());
			}
		}
		public function deleteOffer($id) 
		{
			try 
			{
				$pdo = config::getConnexion();
				$query = $pdo->prepare("DELETE FROM TravelOffer WHERE id = :id");
				$query->execute(['id' => $id]);
				return $query->rowCount() > 0;
			} 
			catch (Exception $e) 
			{
				return false;
			}
		}
		public function getOfferById($id) 
		{
			try 
			{
				$pdo = config::getConnexion();
				$query = $pdo->prepare("SELECT * FROM TravelOffer WHERE id = :id");
				$query->execute(['id' => $id]);
				return $query->fetch();
			} 
			catch (Exception $e) 
			{
				return null;
			}
		}
		public function updateOffer($data) 
		{
			try 
			{
				$pdo = config::getConnexion();
				$query = $pdo->prepare("UPDATE TravelOffer SET title = :title, destination = :destination, departure = :departure, `return` = :return, price = :price, category = :category WHERE id = :id");
				$query->execute($data);
			} 
			catch (Exception $e) 
			{
				die('Error: ' . $e->getMessage());
			}
		}		
    }
?>