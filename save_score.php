<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$setId = $data['set_id'];
$score = $data['score'];

$stmt = $mysqli->prepare("INSERT INTO flashcard_scores (user_id, set_id, score) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $userId, $setId, $score);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Score saved']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save score']);
}
