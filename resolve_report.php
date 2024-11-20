<?php
session_start();
include 'connect.php';

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Access denied.']);
    exit();
}

// Get the report ID from the request
$data = json_decode(file_get_contents('php://input'), true);
$reportId = $data['report_id'] ?? null;

if (!$reportId) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid report ID.']);
    exit();
}

// Mark the report as resolved
$stmt = $mysqli->prepare("UPDATE reports SET status = 'resolved' WHERE id = ?");
$stmt->bind_param("i", $reportId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Report marked as resolved.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to mark the report as resolved.']);
}

$stmt->close();
