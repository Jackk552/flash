<?php
session_start();
include 'connect.php';
session_regenerate_id(true);

// Set response header for JSON output
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$setId = isset($_GET['set_id']) ? $_GET['set_id'] : null;

if (!$setId) {
    echo json_encode(['status' => 'error', 'message' => 'Set ID is required']);
    exit();
}

$leaderboard = [];

try {
    // Prepare the query to fetch all leaderboard data for the specified set_id
    $stmt = $mysqli->prepare("SELECT accounts.username, flashcard_scores.score 
                              FROM flashcard_scores 
                              INNER JOIN accounts ON flashcard_scores.user_id = accounts.id 
                              WHERE flashcard_scores.set_id = ? 
                              ORDER BY flashcard_scores.score DESC");
    $stmt->bind_param("i", $setId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the leaderboard data
    if ($result->num_rows > 0) {
        $leaderboard = $result->fetch_all(MYSQLI_ASSOC);
    }

    echo json_encode([
        'status' => 'success',
        'leaderboard' => $leaderboard
    ]);
} catch (Exception $e) {
    // Catch any errors and send the error response
    echo json_encode(['status' => 'error', 'message' => 'Error fetching leaderboard: ' . $e->getMessage()]);
    exit();
}
