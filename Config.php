<?php
// Add these lines in your config.php or somewhere secure
define('STRIPE_SECRET_KEY', 'sk_test_51QT8a4H8w9WYGc2qdpxV6pztdcMQZMcsxSAiaOtCEajuImSIHL6FrRr18U9pMRhV59xBlMEiKXJ18nwDQ1hStOsO00BHyIP8pX');
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51QT8a4H8w9WYGc2qOZ9kTlqY6ML7DBosVrFIf1G7FUcuslEMo0aBFHSLr9qj34ISPkBHcsIEauWxSDPcbvUij6DJ00iu0SpUtG');

	class config 
	{
		private static $pdo = null;
		public static function getConnexion()
		{
			if (!isset(self::$pdo)) 
			{
				try
				{
					self::$pdo = new PDO
					(
						"mysql:host=localhost;dbname=projet",  
						"root",  // Nom d'utilisateur
						"",  // Mot de passe vide
						[
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
						]
					);
				} 
				catch (Exception $e)
				{
					die('Erreur : ' . $e->getMessage());
				}
			}
			return self::$pdo;
		}
	}
	
	config::getConnexion();
	
?>