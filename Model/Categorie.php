<?php
class Categorie
{
    public int $Id_produit;
    public int $id_Categorie;
    public string $Nom;
   
    public function __construct(int $Id_produit, string $Nom)
    {
        $this->Id_produit = $Id_produit;
        $this->Nom = $Nom;
    }

    /**
     * Get the value of Id_produit
     */
    public function getId_produit(): int
    {
        return $this->Id_produit;
    }

    /**
     * Set the value of Id_produit
     */
    public function setId_produit(int $Id_produit): self
    {
        $this->Id_produit = $Id_produit;
        return $this;
    }

    /**
     * Get the value of Nom
     */
    public function getNom(): string
    {
        return $this->Nom;
    }

    /**
     * Set the value of Nom
     */
    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;
        return $this;
    }

    /**
     * Get the value of id_Categorie
     */
    public function getId_Categorie(): int
    {
        return $this->id_Categorie;
    }

    /**
     * Set the value of id_Categorie
     */
    public function setId_Categorie(int $id_Categorie): self
    {
        $this->id_Categorie = $id_Categorie;
        return $this;
    }
}
?>
