<?php

require_once __DIR__ . '/../config.php';

class ChartsController 
{
    public function getServiceRequestsByStatus() 
    {
        try 
        {
            $pdo = config::getConnexion();
            $stmt = $pdo->query
            ("
                SELECT status, COUNT(*) AS count 
                FROM servicerequest 
                GROUP BY status
            ");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $statuses = ['pending', 'approved', 'disapproved'];
            $finalResult = [];
            foreach ($statuses as $status) 
            {
                $found = false;
                foreach ($result as $row) 
                {
                    if ($row['status'] === $status) 
                    {
                        $finalResult[] = $row;
                        $found = true;
                        break;
                    }
                }
            }
            return $finalResult;
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getTotalVisitors() 
    {
        try {
            $pdo = config::getConnexion();
            $stmt = $pdo->query("SELECT COUNT(*) AS total FROM user");
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getUsersByRole() 
    {
        try 
        {
            $pdo = config::getConnexion();
            $stmt = $pdo->query("
                SELECT 
                    CASE 
                        WHEN role = 'user' THEN 'client'
                        ELSE role 
                    END AS role_display,
                    COUNT(*) AS count 
                FROM user 
                WHERE role IN ('admin', 'user') 
                GROUP BY role_display
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getTotalProducts() 
    {
        try 
        {
            $pdo = config::getConnexion();
            $stmt = $pdo->query("SELECT COUNT(*) AS total FROM produit");
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getTotalServices() 
    {
        try 
        {
            $pdo = config::getConnexion();
            $stmt = $pdo->query("SELECT COUNT(*) AS total FROM service");
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getTotalReclamations() 
    {
        try 
        {
            $pdo = config::getConnexion();
            $stmt = $pdo->query("SELECT COUNT(*) AS total FROM reclamation");
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } 
        catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>