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
    public function deleteProduct($Id)
    {
        
        $sql = "DELETE FROM produit WHERE Id_Produit = :Id_Produit";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':Id_Produit', $Id);
        
        try {
            $req->execute();
            echo $req->rowCount() . " row(s) deleted"; 
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function updateProduit($id, Produit $produit)
    {
        try {
            $query = "UPDATE produit 
                      SET Image = :Image, Nom = :Nom, Description = :Description, Prix = :Prix, Quantite = :Quantite 
                      WHERE Id_Produit = :Id_Produit";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':Image', $produit->Image);
            $stmt->bindValue(':Nom', $produit->Nom);
            $stmt->bindValue(':Description', $produit->Description);
            $stmt->bindValue(':Prix', $produit->Prix);
            $stmt->bindValue(':Quantite', $produit->Quantite);
            $stmt->bindValue(':Id_Produit', $id);

            $stmt->execute();
            echo $stmt->rowCount() . " row(s) updated"; 
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    public function getProduitById($id)
{
    try {
        $query = "SELECT * FROM produit WHERE Id_Produit = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return null;
    }
}
public function AfficherProduitParNomCategorie($nomCategorie) {
    $sql = "SELECT p.* FROM produit p 
            INNER JOIN categorie c ON p.Id_Produit = c.Id_produit 
            WHERE c.Nom = :nomCategorie";
    $db = config::getConnexion();
    try {
        $req = $db->prepare($sql);
        $req->bindValue(':nomCategorie', $nomCategorie);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}

}
?>

