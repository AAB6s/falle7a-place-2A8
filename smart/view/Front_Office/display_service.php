<?php
    require_once '../../Controller/serviceController.php';
    $services = (new ServiceController())->listServices($_GET['filter_service_type']==="" ? null:$_GET['filter_service_type']);
    echo json_encode($services);
?>