<?php 
require_once __DIR__ . '/../model/reclamation.php';
require_once __DIR__ . '/../config.php';
class ReclamationC 
{
    public function addReclamation(Reclamation $reclamation) 
    {
        $sql = "INSERT INTO Reclamation (description) VALUES (:description)";
        $db = config::getConnexion();
        try {
            $req = $db->prepare($sql);
            $req->bindValue(':description', $reclamation->getText_rec());
            $req->execute();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    public function listeReclamations() 
    {
        $sql = "SELECT * FROM reclamation";
        $db = config::getConnexion();
        try 
        {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) 
        {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>