<?php
session_start();
include 'connect.php';

// Set the header to indicate a JSON response
header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

// Validate data
if (empty($data['flashcard_id']) || empty($data['set_id']) || empty($data['reason'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
    exit();
}

$flashcardId = (int) $data['flashcard_id'];
$setId = (int) $data['set_id'];
$userId = $_SESSION['user_id'];
$reason = $mysqli->real_escape_string($data['reason']);  // Escape the reason to prevent SQL injection

// Prepare the SQL statement to insert the report with the reason
$stmt = $mysqli->prepare("INSERT INTO reports (flashcard_id, set_id, user_id, reason) VALUES (?, ?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("iiis", $flashcardId, $setId, $userId, $reason);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Report submitted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to submit the report.']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database query failed.']);
}
