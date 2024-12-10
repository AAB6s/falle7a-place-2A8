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
                'Image' => $produit->getImage(), 
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
                SET Nom = :Nom, 
                    Description = :Description, 
                    Prix = :Prix, 
                    Quantite = :Quantite, 
                    Image = :Image, 
                    id_Categorie = :id_Categorie 
                WHERE Id_Produit = :id_Produit";
        
        $db = config::getConnexion();
        
        try {
            $query = $db->prepare($sql);
            
            // Lier les valeurs
            $query->bindValue(':id_Produit', $id_Produit, PDO::PARAM_INT);
            $query->bindValue(':Nom', $produit->getNom(), PDO::PARAM_STR);
            $query->bindValue(':Description', $produit->getDescription(), PDO::PARAM_STR);
            $query->bindValue(':Prix', $produit->getPrix(), PDO::PARAM_STR);
            $query->bindValue(':Quantite', $produit->getQuantite(), PDO::PARAM_INT);
            $query->bindValue(':Image', $produit->getImage(), PDO::PARAM_STR);
            $query->bindValue(':id_Categorie', $produit->getIdCategorie(), PDO::PARAM_INT); // Ajouter la catégorie
            
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

public function rechercherProduits($searchQuery) {
    $db = config::getConnexion(); // Database connection
    
    try {
        $sql = "SELECT Id_Produit, Nom, Description, Prix, Image 
                FROM produit 
                WHERE Nom LIKE :searchQuery"; // The LIKE clause for name search
        
        $stmt = $db->prepare($sql);
        $stmt->execute(['searchQuery' => '%' . $searchQuery . '%']); // Bind the parameter

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Debugging: print the products found
        echo "Found products: " . count($products); // Should show how many products were found

        return $products; // Return matching products
    } catch (Exception $e) {
        // If any error occurs, return an empty array
        return [];
    }
}



public function getProduitsByPrix($maxPrix) {
    // Connexion à la base de données
    $db = config::getConnexion();

    try {
        // Requête pour récupérer les produits dont le prix est inférieur ou égal à maxPrix
        $sql = "SELECT * FROM produit WHERE Prix <= :maxPrix ORDER BY Prix DESC";
        $stmt = $db->prepare($sql);

        // Bind de la valeur du prix maximum
        $stmt->bindParam(':maxPrix', $maxPrix, PDO::PARAM_STR);
        $stmt->execute();

        // Retourner tous les produits filtrés
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Si une erreur se produit, retourner un tableau vide
        return [];
    }
}


public function getRatingByIdProduit($Id_Produit) {
    $db = config::getConnexion();
    try {
        $stmt = $db->prepare("SELECT rating FROM produit WHERE Id_Produit = :Id_Produit");
        $stmt->bindParam(':Id_Produit', $Id_Produit, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Si une note est trouvée, on la retourne
        if ($result) {
            return $result['rating'];
        } else {
            return null; // Pas de note existante
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération de la note : " . $e->getMessage();
        return null;
    }
}

public function insertRating($Id_Produit, $rating) {
    try {
        // Préparer la requête pour insérer la note dans la base de données
        $stmt = $this->pdo->prepare("INSERT INTO produit (Id_Produit, rating) VALUES (:Id_Produit, :rating)");
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':Id_Produit', $Id_Produit, PDO::PARAM_INT);

        // Exécuter la requête
        $stmt->execute();
        echo "Note insérée avec succès!";
        return true;
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion : " . $e->getMessage();
        return false;
    }
}

public function updateRating($Id_Produit, $rating) {
    try {
        // Préparer la requête pour mettre à jour la note dans la base de données
        $stmt = $this->pdo->prepare("UPDATE produit SET rating = :rating WHERE Id_Produit = :Id_Produit");
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':Id_Produit', $Id_Produit, PDO::PARAM_INT);

        // Exécuter la requête
        $stmt->execute();
        echo "Note mise à jour avec succès!";
        return true;
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour : " . $e->getMessage();
        return false;
    }
}




}
?>


