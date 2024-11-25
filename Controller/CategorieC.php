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
                'Nom' => $Categorie->getNom(),  // Assurez-vous d'utiliser getNom() et non getCategorie()
                'Id_produit' => $Categorie->getId_produit()
            ]);
            echo $query->rowCount() . " record(s) UPDATED successfully <br>";
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

    
    public function AfficherNom_produit() {
        $sql = "SELECT Id_produit, Nom FROM produit"; 
        $db = config::getConnexion();
        try {
            $list_Nom_produit = $db->query($sql);
            return $list_Nom_produit->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    

    private $db;

    public function __construct() {
        // Initialisez votre connexion à la base de données ici
        $this->db = config::getConnexion(); // ou votre méthode pour obtenir une connexion
    }

    public function getCategorieById($id_Categorie) {
        try {
            $query = $this->db->prepare("SELECT * FROM categorie WHERE id_Categorie = :id_Categorie");
            $query->bindParam(':id_Categorie', $id_Categorie, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch(PDO::FETCH_ASSOC); // Retourne les informations de la catégorie
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Les autres méthodes de votre classe...
}
    


?>
