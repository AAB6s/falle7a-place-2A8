<?php

class user {
    private $name;
    private $email;
    private $password;
    private $adress;
    private $role;
    private $avatar;

    public function __construct($name, $email, $password, $adress, $role = 'user', $avatar = null) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->adress = $adress;
        $this->role = $role;
        $this->avatar = $avatar;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function getAdress() {
        return $this->adress;
    }
    public function setAdress($adress) {
        $this->adress = $adress; 
    }
    public function getRole() {
        return $this->role;
    }
    public function setRole($role) {
        $this->role = $role; 
    }
    public function getAvatar() {
        return $this->avatar;
    }
    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }
}
