<?php
require_once '../../../models/Employe.php';
require_once '../../../config/config.php'; 

class EmployeController {
    private $db;

    public function __construct() {
        // Get the database connection from the config class
        $this->db = config::getConnexion();
    }

    // Create a new employee record
    public function createEmploye($nom, $prenom, $email, $telephone, $status) {
        $employe = new Employe($nom, $prenom, $email, $telephone, $status);
        $query = "INSERT INTO employes (nom, prenom, email, telephone, status) VALUES (:nom, :prenom, :email, :telephone, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    // Read a specific employee record by ID
    public function readEmploye($id) {
        $query = "SELECT * FROM employes WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new Employe($data['nom'], $data['prenom'], $data['email'], $data['telephone'], 'denied', $data['id']);
        }
        return null; // Return null if not found
    }

    // Update an existing employee record
    public function updateEmploye($id, $nom, $prenom, $email, $telephone, $status) {
        $employe = new Employe($nom, $prenom, $email, $telephone, $status, $id);
        $query = "UPDATE employes SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $employe->getId());
        $stmt->bindParam(':nom', $employe->getNom());
        $stmt->bindParam(':prenom', $employe->getPrenom());
        $stmt->bindParam(':email', $employe->getEmail());
        $stmt->bindParam(':telephone', $employe->getTelephone());
        $stmt->bindParam(':status', $employe->getStatus());
        return $stmt->execute();
    }

    // Delete an employee record by ID
    public function deleteEmploye($id) {
        $query = "DELETE FROM employes WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Get all employee records
    public function getAllEmployes() {
        $query = "SELECT * FROM employes";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $employes = [];
        foreach ($results as $data) {
            $employes[] = new Employe($data['nom'], $data['prenom'], $data['email'], $data['telephone'], $data['status'], $data['id']);
        }
        return $employes;
    }
    public function getApprovedEmployees() {
        $sql = "SELECT * FROM employes WHERE status = :status";
        $stmt = $this->db->prepare($sql);
        $status = 'approved';
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        
        $stmt->execute();
        
        // Fetch all approved employees
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function approveEmployee($employeeId) {
        $sql = "UPDATE employes SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $status = 'approved';
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $employeeId, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    public function denyEmployee($employeeId) {
        $sql = "UPDATE employes SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $status = 'denied';
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $employeeId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>