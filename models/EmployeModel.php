<?php

class EmployeModel {
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Échec de la connexion : " . $this->conn->connect_error);
        }
    }

    public function insertEmploye($nom, $prenom, $email, $telephone) {
        $stmt = $this->conn->prepare("INSERT INTO employes (nom, prenom, email, telephone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nom, $prenom, $email, $telephone);

        if ($stmt->execute()) {
            return true;
        } else {
            return $stmt->error;
        }

        $stmt->close();
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>