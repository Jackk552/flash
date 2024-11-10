<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$userId = $_SESSION['user_id'];
$setId = $_GET['set_id'];
$isPublic = $_GET['is_public'];

// Fetch flashcards for the given set
$stmt = $mysqli->prepare("SELECT id, question, answer FROM flashcards WHERE set_id = ?");
$stmt->bind_param("i", $setId);
$stmt->execute();
$result = $stmt->get_result();
$flashcards = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Flashcards</title>
    <link rel="stylesheet" href="style.css">
    <script>
        let flashcards = <?= json_encode($flashcards) ?>;
        let currentIndex = 0;
        let score = 0;

        function checkAnswer() {
            let userAnswer = document.getElementById('user-answer').value.trim();
            if (userAnswer === flashcards[currentIndex].answer) {
                score++;
                alert('Correct!');
            } else {
                alert('Incorrect. The correct answer is: ' + flashcards[currentIndex].answer);
            }
            currentIndex++;
            if (currentIndex < flashcards.length) {
                loadFlashcard();
            } else {
                finishQuiz();
            }
        }

        function loadFlashcard() {
            document.getElementById('question').innerText = flashcards[currentIndex].question;
            document.getElementById('user-answer').value = '';
        }

        function finishQuiz() {
            // Send score to the server if the flashcards are public
            if (<?= $isPublic ?> == 1) {
                fetch('save_score.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ set_id: <?= $setId ?>, score: score })
                }).then(response => response.json()).then(result => {
                    alert('Your score: ' + score);
                    window.location.href = 'home.php';
                });
            } else {
                alert('Your score: ' + score);
                window.location.href = 'home.php';
            }
        }

        window.onload = loadFlashcard;
    </script>
</head>
<body>
    <div class="wrapper">
        <h1>Answer Flashcards</h1>
        <p id="question"></p>
        <input type="text" id="user-answer" placeholder="Enter your answer">
        <button onclick="checkAnswer()">Submit</button>
    </div>
</body>
</html>
