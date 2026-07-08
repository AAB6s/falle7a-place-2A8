<?php
require_once '../../Controller/service_typeController.php';
(new ServiceTypeController())->deleteServiceType($_GET['service_type_id']);
echo json_encode(['success' => true]);
?>