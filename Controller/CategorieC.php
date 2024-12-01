<?php 
include_once '../config.php'; // Inclusion du fichier de configuration pour la base de données
include_once '../Model/Categorie.php';


class CategorieC {

    
    public function AddCategorie($categorie) {
        $sql = "INSERT INTO categorie (Nom) VALUES (:Nom)";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'Nom' => $categorie->getNom()
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Méthode pour afficher toutes les catégories
    public function AfficherCategories() {
        $sql = "SELECT * FROM categorie";
        $db = config::getConnexion();

        try {
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    public function RecupererCategorie($id_Categorie) {
        $sql = "SELECT * FROM categorie WHERE id_Categorie = :id_Categorie";
        $db = config::getConnexion();
    
        try {
            $query = $db->prepare($sql);
            $query->execute(['id_Categorie' => $id_Categorie]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
    
            // Si une catégorie est trouvée, créer une instance de l'objet Categorie
            if ($result) {
                return new Categorie($result['id_Categorie'], $result['Nom']);
            }
            return null; // Si aucune catégorie n'est trouvée
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    
    public function ModifierCategorie($categorie) {
        $sql = "UPDATE categorie SET Nom = :Nom WHERE id_Categorie = :id_Categorie";
        $db = config::getConnexion();
    
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'Nom' => $categorie->getNom(),
                'id_Categorie' => $categorie->getIdCategorie()
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
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
    public function deleteCategorie($id_Categorie) {
        $sql = "DELETE FROM categorie WHERE id_Categorie = :id_Categorie";
        $db = config::getConnexion();
    
        try {
            $query = $db->prepare($sql);
            $query->execute(['id_Categorie' => $id_Categorie]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
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
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categorie";
        $db = config::getConnexion();

        try {
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    
    }  
}    
/*public function getCategories() {
    $sql = "SELECT Nom FROM categorie"; // Adjust if necessary
    $db = config::getConnexion();

    try {
        $query = $db->prepare($sql);
        $query->execute();
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
        
        // Check if the query returned any results
        if (!$categories) {
            return []; // Return an empty array if no categories are found
        }
        
        return $categories;
    } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}
  
*/

?>
