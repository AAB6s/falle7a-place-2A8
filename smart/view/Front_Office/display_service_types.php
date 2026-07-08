<?php
    require_once '../../Controller/service_typeController.php';
    $serviceTypes = (new ServiceTypeController())->listServiceTypes();
    echo json_encode($serviceTypes);
?>