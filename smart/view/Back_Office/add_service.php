<?php
require_once '../../Controller/serviceController.php';
(new ServiceController())->addService
([
'name' => $_GET['name'],
'description' => $_GET['description'],
'service_type_id' => $_GET['service_type_id']
]);
echo json_encode(['success' => true]);
?>