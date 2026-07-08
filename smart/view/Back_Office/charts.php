<?php
require_once __DIR__ . '/../../controller/charts.php';
$controller = new ChartsController();
$data = 
    [
        'totalVisitors' => $controller->getTotalVisitors(),
        'usersByRole' => $controller->getUsersByRole(),
        'serviceRequestsByStatus' => $controller->getServiceRequestsByStatus(),
        'totalProducts' => $controller->getTotalProducts(),
        'totalServices' => $controller->getTotalServices(),
        'totalReclamations' => $controller->getTotalReclamations(),
    ];
    echo json_encode($data);
?>