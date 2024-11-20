<?php
session_start();
include 'connect.php';

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Access denied.']);
    exit();
}

// Get the flashcard ID from the request
$data = json_decode(file_get_contents('php://input'), true);
$flashcardId = $data['flashcard_id'] ?? null;

// Check if the flashcard ID is valid
if (!$flashcardId || !filter_var($flashcardId, FILTER_VALIDATE_INT)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid flashcard ID.']);
    exit();
}

// Check if the flashcard exists in the database
$stmt = $mysqli->prepare("SELECT * FROM flashcards WHERE id = ?");
$stmt->bind_param("i", $flashcardId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Flashcard exists, proceed with deletion
    $stmt = $mysqli->prepare("DELETE FROM flashcards WHERE id = ?");
    $stmt->bind_param("i", $flashcardId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Flashcard deleted.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete the flashcard.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Flashcard not found.']);
}

$stmt->close();
