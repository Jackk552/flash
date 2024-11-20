<?php
// Assuming you already have a connection established
require 'connect.php';
// Get the data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

// Get the flashcard set ID and name
$setId = $data['set_id'];
$setName = $data['name'];
$isPublic = $data['is_public'];

// Update the flashcard set information
$stmt = $mysqli->prepare("UPDATE flashcardsets SET name = ?, is_public = ? WHERE id = ?");
$stmt->bind_param("sii", $setName, $isPublic, $setId); // Update the flashcard set
$stmt->execute();

// Update each flashcard in the set
foreach ($data['cards'] as $card) {
    $question = $card['question'];
    $answer = $card['answer'];
    $flashcardId = $card['id'];

    // Update the individual flashcard record
    $stmt = $mysqli->prepare("UPDATE flashcards SET question = ?, answer = ? WHERE id = ?");
    $stmt->bind_param("ssi", $question, $answer, $flashcardId); // Update each flashcard
    $stmt->execute();
}

// Return a success response
echo json_encode(['status' => 'success']);
