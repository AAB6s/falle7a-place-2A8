<?php 
include '../config.php';
include '../Model/Categorie.php';
include '../Model/Produit.php';

class CategorieC {

    
    public function AddCategorie($Categorie)
    {
        $sql = "INSERT INTO categorie (Id_produit, Nom)
                VALUES (:Id_produit, :Nom)";
        $db = config::getConnexion();
        try {
            $req = $db->prepare($sql);
            $Id_produit = $Categorie->getId_produit();
            $Nom = $Categorie->getNom();
            
            $req->bindValue(':Id_produit', $Id_produit);
            $req->bindValue(':Nom', $Nom);

            $req->execute();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    
    public function AfficherCategorie()
    {
        $sql = "SELECT * FROM categorie";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    
    public function deleteCategorie($id_Categorie)
    {
        $sql = "DELETE FROM categorie WHERE id_Categorie = :id_Categorie";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_Categorie', $id_Categorie);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());                           
        }
    }

    
    function updateCategorie($Categorie, $id_Categorie)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE categorie SET  
                    Id_produit = :Id_produit,
                    Nom = :Nom
                WHERE id_Categorie = :id_Categorie'
            );
            $query->execute([
                'id_Categorie' => $id_Categorie,
                'Nom' => $Categorie->getCategorie(), 
                'Id_produit' => $Categorie->getId_produit()
            ]);
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

   
    function showCategorie($id_Categorie)
    {
        $sql = "SELECT * FROM categorie WHERE id_Categorie = :id_Categorie";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id_Categorie', $id_Categorie);
            $query->execute();

            $categorie = $query->fetch();
            return $categorie;  
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    
    public function AfficherId_produit()
    {
        $sql = "SELECT Id_produit FROM produit";
        $db = config::getConnexion();
        try {
            $list_Id_produit = $db->query($sql);
            return $list_Id_produit;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

}
?>
