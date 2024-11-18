<?php

class Config 
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
                    "mysql:host=localhost;dbname=employes_db",  // Assurez-vous que le nom de la base de données est correct
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

// Test de connexion
Config::getConnexion();
?>