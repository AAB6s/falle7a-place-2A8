<?php
class Categorie {
    // Déclaration des propriétés de la catégorie
    private $id_Categorie;
    private $Nom;

    // Constructeur de la classe, permettant d'initialiser les propriétés
    public function __construct($id_Categorie = null, $Nom) {
        $this->id_Categorie = $id_Categorie;
        $this->Nom = $Nom;
    }

    // Getter pour l'ID de la catégorie
    public function getIdCategorie() {
        return $this->id_Categorie;
    }

    // Setter pour l'ID de la catégorie
    public function setIdCategorie($id_Categorie) {
        $this->id_Categorie = $id_Categorie;
    }

    // Getter pour le nom de la catégorie
    public function getNom() {
        return $this->Nom;
    }

    // Setter pour le nom de la catégorie
    public function setNom($Nom) {
        $this->Nom = $Nom;
    }

    // Méthode pour afficher les informations de la catégorie sous forme de chaîne
    public function afficher() {
        return "ID: " . $this->id_Categorie . " - Nom: " . $this->Nom;
    }
}
?>
