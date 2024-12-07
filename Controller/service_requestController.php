<?php

require_once __DIR__ . '/../Model/service_request.php';
require_once __DIR__ . '/../Config.php';

class ServiceRequestController 
{
    public function listRequests($status = null, $client_id = null) 
    {
        try 
        {
            $pdo = Config::getConnexion();
            $query = 
            "
                SELECT * FROM servicerequest 
                WHERE (:status IS NULL OR status = :status)
                AND (:client_id IS NULL OR client_id = :client_id)
            ";
            $stmt = $pdo->prepare($query);
            $stmt->execute
            ([
                ':status' => $status,
                ':client_id' => $client_id
            ]);
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }    

    public function addRequest(ServiceRequest $request) 
    {
        try 
        {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("
                INSERT INTO servicerequest 
                (client_id, custom_name, custom_description, worker_count, location, date_needed, date_requested, status) 
                VALUES 
                (:client_id, :custom_name, :custom_description, :worker_count, :location, :date_needed, :date_requested, :status)
            ");
            
            $query->execute([
                'client_id' => $request->getClientId() ?? null,
                'custom_name' => $request->getCustomName(),
                'custom_description' => $request->getCustomDescription(),
                'worker_count' => $request->getWorkerCount(),
                'location' => $request->getLocation(),
                'date_needed' => $request->getDateNeeded()->format('Y-m-d H:i:s'),
                'date_requested' => $request->getDateRequested()->format('Y-m-d H:i:s'),
                'status' => $request->getStatus()
            ]);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }         

    public function deleteRequest($id) 
    {
        try 
        {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("DELETE FROM servicerequest WHERE request_id = :id");
            $query->execute(['id' => $id]);
            return $query->rowCount() > 0;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function getRequestById($id) 
    {
        try 
        {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("SELECT * FROM servicerequest WHERE request_id = :id");
            $query->execute(['id' => $id]);
            return $query->fetch();
        } 
        catch (Exception $e) 
        {
            return null;
        }
    }

    public function updateRequest($data) 
    {
        try 
        {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("UPDATE servicerequest SET client_id = :client_id, custom_name = :custom_name, custom_description = :custom_description, worker_count = :worker_count, location = :location, date_needed = :date_needed, date_requested = :date_requested, status = :status WHERE request_id = :id");
            $query->execute($data);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }

    public function approveRequest($requestId) 
    {
        try 
        {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("UPDATE servicerequest SET status = :status WHERE request_id = :id");
            $query->execute([
                'status' => 'Approved',
                'id' => $requestId
            ]);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }
    
    public function disapproveRequest($requestId) 
    {
        try 
        {
            $pdo = Config::getConnexion();
            $query = $pdo->prepare("UPDATE servicerequest SET status = :status WHERE request_id = :id");
            $query->execute
            ([
                'status' => 'Disapproved',
                'id' => $requestId
            ]);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }
}

?>