<?php
require_once '../config.php';
require_once '../model/user.php';

class UserController {
    // Fetch all users from the database
    public function getUser() {
        $conn = config::getConnexion();
        $sql = 'SELECT * FROM user';
        try {
            $query = $conn->prepare($sql);
            $query->execute(); // Corrected the misspelling of "execute"
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Add a new user to the database
    public function addUser($user) { 
        $conn = config::getConnexion();
        $sql = "INSERT INTO user (name, email, password, adresse) VALUES (:name, :email, :password, :adress)";
        try {
            $query = $conn->prepare($sql);
            $query->execute([ // Changed semicolons to commas inside the array
                ':name' => $user->getName(),
                ':email' => $user->getEmail(),
                ':password' => $user->getPassword(),
                ':adress' => $user->getAdress()
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Delete a user from the database
    public function deleteUser($id) { 
        $conn = config::getConnexion();
        $sql = 'DELETE FROM user WHERE id = :id';
        try {
            $query = $conn->prepare($sql);
            $query->execute([ // Corrected "excute" to "execute"
                ':id' => $id
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Update a user's information in the database
    public function updateUser($id, $user) {
        $conn = config::getConnexion();
        $sql = "UPDATE user SET name=:name, email = :email, password = :password , adresse =:adress WHERE id = :id";
        try {
            $query = $conn->prepare($sql);
            $query->execute([ 
                ':id' => $id,
                ':name'=>$user->getName(),
                ':email' => $user->getEmail(),
                ':password' => $user->getPassword(),
                ':adress' => $user->getAdress()
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Get a user by ID from the database
    public function getUserbyId($id) {
        $conn = config::getConnexion();
        $sql = "SELECT * FROM user WHERE id = :id"; // Fixed SQL query to include "FROM user"
        try {
            $query = $conn->prepare($sql);
            $query->execute([':id' => $id]); // Corrected "excute" to "execute"
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
?>
