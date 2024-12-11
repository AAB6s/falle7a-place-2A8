<?php
class Employe {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $telephone;
    private $status;
    private $isVerified;
    private $emailConfirmationToken;

    // Constructor
    public function __construct($nom, $prenom, $email, $telephone, $status, $isVerified = false, $emailConfirmationToken = null, $id = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->status = $status;
        $this->isVerified = $isVerified; 
        $this->emailConfirmationToken = $emailConfirmationToken; }
    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getIsVerified() {
        return $this->isVerified;
    }

    public function getEmailConfirmationToken() { // New getter
        return $this->emailConfirmationToken;
    }

    // Setters
    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setIsVerified($isVerified) {
        $this->isVerified = $isVerified;
    }

    public function setEmailConfirmationToken($token) { // New setter
        $this->emailConfirmationToken = $token;
    }
}
?>