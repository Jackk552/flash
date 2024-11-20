<?php
session_start();
include 'connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$userId = $_SESSION['user_id'];

// Get the raw POST data and decode it
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['set_id']) || !isset($data['score'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
    exit();
}

$setId = intval($data['set_id']);
$score = intval($data['score']);

// Prepare the SQL statement to insert or update the score
$stmt = $mysqli->prepare("INSERT INTO flashcard_scores (user_id, set_id, score) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE score = GREATEST(score, VALUES(score))");
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement']);
    exit();
}

$stmt->bind_param("iii", $userId, $setId, $score);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Score saved successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save score']);
}

$stmt->close();
$mysqli->close();
