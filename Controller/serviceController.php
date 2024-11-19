<?php

require_once __DIR__ . '/../Model/service.php';
require_once __DIR__ . '/../Config.php';

class ServiceController 
{
    public function listServices() 
    {
        try 
        {
            $pdo = Config::getConnexion();
            $stmt = $pdo->prepare("SELECT * FROM service");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }

    public function addService($service) 
    {
        try 
        {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("INSERT INTO service (name, description) VALUES (:name, :description)");
            $query->execute([
                'name' => $service['name'],
                'description' => $service['description']
            ]);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }

    public function deleteService($id) 
    {
        try 
        {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("DELETE FROM service WHERE service_id = :id");
            $query->execute(['id' => $id]);
            return $query->rowCount() > 0;
        } 
        catch (Exception $e)
        {
            return false;
        }
    }

    public function getServiceById($id) 
    {
        try 
        {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("SELECT * FROM service WHERE service_id = :id");
            $query->execute(['id' => $id]);
            return $query->fetch();
        } 
        catch (Exception $e) 
        {
            return null;
        }
    }

    public function updateService($data) 
    {
        try
        {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("UPDATE service SET name = :name, description = :description WHERE service_id = :id");
            $query->execute([
                'name' => $data['name'],
                'description' => $data['description'],
                'id' => $data['service_id']
            ]);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }
    
    public function detectDuplicates() 
    {
        try 
        {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("
                SELECT name, COUNT(*) as count
                FROM service
                GROUP BY name
                HAVING COUNT(*) > 1
            ");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }

    public function deleteDuplicates() 
    {
        try 
        {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("
                DELETE s1
                FROM service s1
                INNER JOIN (
                    SELECT name, MAX(service_id) as latest_id
                    FROM service
                    GROUP BY name
                ) s2 
                ON s1.name = s2.name AND s1.service_id != s2.latest_id
            ");
            $query->execute();
            return $query->rowCount();
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }
}

?>