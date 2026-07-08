<?php

require_once __DIR__ . '/../model/service_type.php';
require_once __DIR__ . '/../config.php';

class ServiceTypeController 
{
    public function listServiceTypes() 
    {
        try 
        {
            $pdo = config::getConnexion();
            $stmt = $pdo->query("SELECT * FROM service_type");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }

    public function addServiceType($serviceType) 
    {
        try 
        {
            $pdo = config::getConnexion();
            $query = $pdo->prepare
            ("
                INSERT INTO service_type (name, short_description, icon) 
                VALUES (:name, :short_description, :icon)
            ");
            $query->execute([
                'name' => $serviceType['name'],
                'short_description' => $serviceType['short_description'],
                'icon' => $serviceType['icon']
            ]);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }

    public function deleteServiceType($id) 
    {
        try 
        {
            $pdo = config::getConnexion();
            $query = $pdo->prepare("DELETE FROM service_type WHERE service_type_id = :id");
            $query->execute(['id' => $id]);
            return $query->rowCount() > 0;
        } 
        catch (Exception $e)
        {
            return false;
        }
    }

    public function getServiceTypeById($id) 
    {
        try 
        {
            $pdo = config::getConnexion();
            $query = $pdo->prepare("SELECT * FROM service_type WHERE service_type_id = :id");
            $query->execute(['id' => $id]);
            return $query->fetch();
        } 
        catch (Exception $e) 
        {
            return null;
        }
    }

    public function updateServiceType($data) 
    {
        try
        {
            $pdo = config::getConnexion();
            $query = $pdo->prepare
            ("
                UPDATE service_type 
                SET name = :name, short_description = :short_description, icon = :icon 
                WHERE service_type_id = :id
            ");
            $query->execute
            ([
                'name' => $data['name'],
                'short_description' => $data['short_description'],
                'icon' => $data['icon'],
                'id' => $data['service_type_id']
            ]);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }
}

?>