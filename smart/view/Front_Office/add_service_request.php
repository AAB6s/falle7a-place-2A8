<?php
    require_once __DIR__.'/../../Controller/service_requestController.php';
    $serviceRequestController = new ServiceRequestController();
    $serviceRequest = new ServiceRequest
    (
        requestId: 0,
        clientId: $_GET['client_id'],
        customName: $_POST['service_selection'],
        customDescription: $_POST['description'],
        workerCount: $_POST['worker_count'],
        location: $_POST['location'],
        dateNeeded: new DateTime($_POST['preferred_date'] . ' ' . $_POST['preferred_time']),
        dateRequested: new DateTime(),
        status: 'Pending'
    );
    $serviceRequestController->addRequest($serviceRequest);
    echo json_encode(['status' => 'success']);
?>