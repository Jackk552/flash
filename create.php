<?php
require 'connect.php';  // Database connection file
session_start();
session_regenerate_id(true);

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    header("Location: index.php");
    exit();
}

// Read and decode the JSON data sent from JavaScript
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
    exit;
}

$userId = $_SESSION['user_id'];
$flashcardName = $data['name'];
$cards = $data['cards'];
$isPublic = isset($data['is_public']) ? (int)$data['is_public'] : 0;  // Default to private (0)

// Initialize response array
$response = [];

// Insert flashcard set with the 'is_public' field
$sql = "INSERT INTO flashcardsets (name, user_id, is_public) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sii", $flashcardName, $userId, $isPublic); // Include is_public in the bind_param
if ($stmt->execute()) {
    $flashcardSetId = $stmt->insert_id;  // Get the new set's ID

    // Insert each flashcard
    $allCardsInserted = true;
    foreach ($cards as $card) {
        $question = $card['question'];
        $answer = $card['answer'];

        $sql = "INSERT INTO flashcards (set_id, question, answer) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("iss", $flashcardSetId, $question, $answer);
        if (!$stmt->execute()) {
            $allCardsInserted = false;
            break;  // Exit the loop if any card fails to save
        }
    }

    if ($allCardsInserted) {
        // Successfully inserted all flashcards
        $response['status'] = 'success';
        $response['message'] = 'Flashcards saved successfully!';
    } else {
        // Error in inserting one or more flashcards
        $response['status'] = 'error';
        $response['message'] = 'Failed to save some flashcards.';
    }
} else {
    // Error in inserting flashcard set
    $response['status'] = 'error';
    $response['message'] = 'Failed to save flashcard set.';
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
