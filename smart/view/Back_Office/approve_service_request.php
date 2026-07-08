<?php
require_once __DIR__ . '/../../Controller/service_requestController.php';
$serviceRequestController = new ServiceRequestController();
$statusFilter = $_GET['status_filter'] ?? 'all';
$serviceRequestController->approveRequest($_GET['assign_id']);
header('Location: service_request_page.php?status_filter=' . urlencode($statusFilter));
?>