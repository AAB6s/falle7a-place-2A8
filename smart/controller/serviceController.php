<?php

require_once __DIR__ . '/../model/service.php';
require_once __DIR__ . '/../config.php';

class ServiceController 
{
    public function listServices($typeId = null) 
    {
        $pdo = config::getConnexion();
        $query = "
            SELECT 
                s.service_id, 
                s.name AS service_name, 
                s.description, 
                t.service_type_id, 
                t.name AS type_name,
                t.icon 
            FROM 
                service s
            INNER JOIN 
                service_type t ON s.service_type_id = t.service_type_id
            WHERE 
                (:typeId IS NULL OR t.service_type_id = :typeId)
            ORDER BY 
                t.service_type_id ASC, s.name ASC
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['typeId' => $typeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addService($service) 
    {
        try 
        {
            $pdo = config::getConnexion();
            $query = $pdo->prepare
            ("
                INSERT INTO service (name, description, service_type_id) 
                VALUES (:name, :description, :service_type_id)
            ");
            $query->execute([
                'name' => $service['name'],
                'description' => $service['description'],
                'service_type_id' => $service['service_type_id']
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
            $pdo = config::getConnexion();
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
            $pdo = config::getConnexion();
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
            $pdo = config::getConnexion();
            $query = $pdo->prepare
            ("
                UPDATE service 
                SET name = :name, description = :description, service_type_id = :service_type_id 
                WHERE service_id = :id
            ");
            $query->execute
            ([
                'name' => $data['name'],
                'description' => $data['description'],
                'service_type_id' => $data['service_type_id'],
                'id' => $data['service_id']
            ]);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }
};

?>