<?php
require_once '../../Controller/service_typeController.php';
(new ServiceTypeController())->updateServiceType([
'service_type_id' => $_GET['service_type_id'],
'name' => $_GET['name'],
'short_description' => $_GET['short_description'],
'icon' => $_GET['icon']
]);
echo json_encode(['success' => true]);
?>