<?php
class Produit
{
    public int $Id_Produit;
    public string $Image;
    public string $Nom;
    public string $Description;
    public float $Prix;
    public int $Quantite;

    // Constructeur pour initialiser les propriétés
    public function __construct(int $Id_Produit, string $Image, string $Nom, string $Description, float $Prix, int $Quantite)
    {
        $this->Id_Produit = $Id_Produit;
        $this->Image = $Image;
        $this->Nom = $Nom;
        $this->Description = $Description;
        $this->Prix = $Prix;
        $this->Quantite = $Quantite;
    }

    // Getter et Setter pour chaque propriété

    public function getIdProduit(): int
    {
        return $this->Id_Produit;
    }

    public function setIdProduit(int $Id_Produit): self
    {
        $this->Id_Produit = $Id_Produit;
        return $this;
    }

    public function getImage(): string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;
        return $this;
    }

    public function getNom(): string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;
        return $this;
    }

    public function getPrix(): float
    {
        return $this->Prix;
    }

    public function setPrix(float $Prix): self
    {
        $this->Prix = $Prix;
        return $this;
    }

    public function getQuantite(): int
    {
        return $this->Quantite;
    }

    public function setQuantite(int $Quantite): self
    {
        $this->Quantite = $Quantite;
        return $this;
    }
}
?>
