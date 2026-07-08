<?php
require_once '../../Controller/serviceController.php';
$result = (new ServiceController())->deleteService($_GET['service_id']);
echo json_encode(['success' => $result]);
?>