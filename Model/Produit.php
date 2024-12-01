<?php
class Produit
{
    public int $id_Produit;
    public string $image;
    public string $nom;
    public string $description;
    public float $prix;
    public int $quantite;
    public int $id_Categorie;

    // Constructeur pour initialiser les propriétés
    public function __construct(
        int $id_Produit,
        string $image,
        string $nom,
        string $description,
        float $prix,
        int $quantite,
        int $id_Categorie
    ) {
        $this->id_Produit = $id_Produit;
        $this->image = $image;
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
        $this->quantite = $quantite;
        $this->id_Categorie = $id_Categorie;
    }

    // Getters et Setters
    public function getIdProduit(): int
    {
        return $this->id_Produit;
    }

    public function setIdProduit(int $id_Produit): self
    {
        $this->id_Produit = $id_Produit;
        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getQuantite(): int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;
        return $this;
    }

    public function getIdCategorie(): int
    {
        return $this->id_Categorie;
    }

    public function setIdCategorie(int $id_Categorie): self
    {
        $this->id_Categorie = $id_Categorie;
        return $this;
    }
}
?>
