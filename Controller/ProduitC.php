<?php
include_once '../Model/Produit.php';
include_once '../Config.php';

class ProduitC
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = config::getConnexion();
    }

    public function addProduit(Produit $produit)
    {
        try {
            $query = "INSERT INTO produit (Image, Nom, Description, Prix, Quantite) 
                      VALUES (:Image, :Nom, :Description, :Prix, :Quantite)";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':Image', $produit->Image);
            $stmt->bindValue(':Nom', $produit->Nom);
            $stmt->bindValue(':Description', $produit->Description);
            $stmt->bindValue(':Prix', $produit->Prix);
            $stmt->bindValue(':Quantite', $produit->Quantite);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function AfficherProduit()
    {
        $sql = "SELECT * FROM produit";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
}
?>
