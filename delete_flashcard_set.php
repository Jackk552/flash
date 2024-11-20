<?php
session_start();
session_regenerate_id(true);
require 'connect.php'; 

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    header("Location: index.php");
    exit();
}

if (!isset($_GET['set_id'])) {
    echo "No flashcard set specified.";
    exit();
}

$userId = $_SESSION['user_id'];
$setId = (int) $_GET['set_id'];

// Delete the flashcard set
$stmt = $mysqli->prepare("DELETE FROM flashcardsets WHERE user_id = ? AND id = ?");
$stmt->bind_param("ii", $userId, $setId);
if ($stmt->execute()) {
    // Redirect to the Flashcards Manager page after deletion
    header("Location: flashcards_manager.php");
    exit();
} else {
    echo "Error deleting flashcard set.";
}
