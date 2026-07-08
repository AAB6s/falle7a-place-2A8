<?php

require_once __DIR__ . '/../model/service_request.php';
require_once __DIR__ . '/../config.php';

class ServiceRequestController 
{
    public function listRequests($status = null, $client_id = null) 
    {
        try 
        {
            $pdo = config::getConnexion();
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
            $pdo = config::getConnexion();
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
            $pdo = config::getConnexion();
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
            $pdo = config::getConnexion();
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
            $pdo = config::getConnexion();
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
            $pdo = config::getConnexion();
            $workerQuery = $pdo->prepare("SELECT worker_count FROM servicerequest WHERE request_id = :id");
            $workerQuery->execute(['id' => $requestId]);
            $workerCount = $workerQuery->fetchColumn();
            $countQuery = $pdo->query("SELECT COUNT(*) FROM employes WHERE available = 'available'");
            $availableWorkers = $countQuery->fetchColumn();
            if ($availableWorkers >= $workerCount) 
            {
                $updateWorkersQuery = $pdo->prepare
                ("
                    UPDATE employes 
                    SET available = 'not available' 
                    WHERE available = 'available' 
                    LIMIT :nbWorkers
                ");
                $updateWorkersQuery->bindParam(':nbWorkers', $workerCount, PDO::PARAM_INT);
                $updateWorkersQuery->execute();
                $updateRequestQuery = $pdo->prepare("UPDATE servicerequest SET status = 'approved' WHERE request_id = :id");
                $updateRequestQuery->execute(['id' => $requestId]);
            } 
            else 
            {
                $updateRequestQuery = $pdo->prepare("UPDATE servicerequest SET status = 'disapproved' WHERE request_id = :id");
                $updateRequestQuery->execute(['id' => $requestId]);
            }
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
            $pdo = config::getConnexion();
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
    
    public function handle_auto() 
    {
        try 
        {
            $pdo = config::getConnexion();
            $pendingRequestsQuery = $pdo->query("SELECT request_id FROM servicerequest WHERE status = 'pending'");
            $pendingRequests = $pendingRequestsQuery->fetchAll(PDO::FETCH_COLUMN);
            foreach ($pendingRequests as $requestId) 
                $this->approveRequest($requestId);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }
}

?>