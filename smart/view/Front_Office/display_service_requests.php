<?php
    require_once __DIR__ . '/../../Controller/service_requestController.php';
    $service_requests_controller = new ServiceRequestController();
    $allRequests = $service_requests_controller->listRequests(null,$_GET['client_id']);
    $pendingRequests = $service_requests_controller->listRequests('Pending',$_GET['client_id']);
    $approvedRequests = $service_requests_controller->listRequests('Approved',$_GET['client_id']);
    $disapprovedRequests = $service_requests_controller->listRequests('Disapproved',$_GET['client_id']);
    echo json_encode
    ([
        'status' => 'success',
        'allRequests' => $allRequests,
        'pendingRequests' => $pendingRequests,
        'approvedRequests' => $approvedRequests,
        'disapprovedRequests' => $disapprovedRequests
    ]);
?>