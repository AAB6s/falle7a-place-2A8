<?php
require_once '../../Controller/service_typeController.php';
(new ServiceTypeController())->addServiceType
([
'name' => $_GET['name'],
'short_description' => $_GET['short_description'] ?? '',
'icon' => $_GET['icon']
]);
echo json_encode(['success' => true]); 
?>