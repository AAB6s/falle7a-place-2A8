<?php
include_once '../Model/Produit.php';
include_once '../Config.php';

class ProduitC
{
    private $pdo;

    public function addProduit($produit) {
        $sql = "INSERT INTO produit (Image, Nom, Description, Prix, Quantite, id_Categorie)
                VALUES (:Image, :Nom, :Description, :Prix, :Quantite, :id_Categorie)";
        $db = config::getConnexion();
    
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'Image' => $produit->getImage(), // Ce doit être le chemin de l'image, pas son contenu
                'Nom' => $produit->getNom(),
                'Description' => $produit->getDescription(),
                'Prix' => $produit->getPrix(),
                'Quantite' => $produit->getQuantite(),
                'id_Categorie' => $produit->getIdCategorie(),
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    



    public function getProduits()
    {
        try {
            $query = $this->pdo->prepare(
                "SELECT p.id_Produit, p.Image, p.Nom AS ProduitNom, p.Description, p.Prix, p.Quantite, c.Nom AS CategorieNom
                 FROM produit p
                 JOIN categorie c ON p.id_Categorie = c.id_Categorie"
            );
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    public function AfficherProduit() {
        // Requête SQL avec jointure pour récupérer les produits et leurs catégories
        $sql = "SELECT p.id_Produit, p.Nom, p.Description, p.Prix, p.Quantite, p.Image, c.Nom AS Nom_Categorie
                FROM produit p
                LEFT JOIN categorie c ON p.id_Categorie = c.id_Categorie";
        
        $db = config::getConnexion();
    
        try {
            // Préparer et exécuter la requête
            $query = $db->prepare($sql);
            $query->execute();
            
            // Récupérer les résultats
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }


    public function updateProduit($id_Produit, Produit $produit) {
        $sql = "UPDATE produit 
                SET Nom = :Nom, Description = :Description, Prix = :Prix, Quantite = :Quantite, Image = :Image 
                WHERE id_Produit = :id_Produit";
    
        $db = config::getConnexion();
        
        try {
            $query = $db->prepare($sql);
            
            // Lier les valeurs
            $query->bindValue(':id_Produit', $id_Produit);
            $query->bindValue(':Nom', $produit->getNom());
            $query->bindValue(':Description', $produit->getDescription());
            $query->bindValue(':Prix', $produit->getPrix());
            $query->bindValue(':Quantite', $produit->getQuantite());
            $query->bindValue(':Image', $produit->getImage());
            
            // Exécuter la requête
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }




    public function deleteProduct($Id_Produit) {
        $db = config::getConnexion();
    
        try {
            // Récupérer l'image du produit
            $query = $db->prepare("SELECT Image FROM produit WHERE id_Produit = :id_Produit");
            $query->execute(['id_Produit' => $Id_Produit]);
            $produit = $query->fetch(PDO::FETCH_ASSOC);
    
            if ($produit && file_exists('../uploads/' . $produit['Image'])) {
                unlink('../uploads/' . $produit['Image']); // Supprimer le fichier
            }
    
            // Supprimer le produit
            $stmt = $db->prepare("DELETE FROM produit WHERE id_Produit = :id_Produit");
            $stmt->bindParam(':id_Produit', $Id_Produit, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    
   
    public function getProduitById($id_Produit) {
        $db = config::getConnexion();
    
        try {
            $sql = "SELECT * FROM produit WHERE id_Produit = :id_Produit";
            $query = $db->prepare($sql);
            $query->bindParam(':id_Produit', $id_Produit, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    

    public function AfficherProduitParNomCategorie($nomCategorie) {
        $sql = "SELECT p.id_Produit, p.Nom, p.Description, p.Prix, p.Quantite, p.Image, c.Nom AS Nom_Categorie
                FROM produit p
                LEFT JOIN categorie c ON p.id_Categorie = c.id_Categorie
                WHERE c.Nom = :nomCategorie"; // Filtrer par nom de catégorie
        
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
    // In your ProduitC class
public function getCategories() {
    $sql = "SELECT  Nom FROM categorie"; // Adjust if necessary
    $db = config::getConnexion();

    try {
        $query = $db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}

    

}
?>


