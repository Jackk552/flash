<?php 
session_start();
session_regenerate_id(true);
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
    // This line won't execute due to exit(), consider placing echo before header if needed.
}

$userId = $_SESSION['user_id'];
$setId = isset($_GET['set_id']) ? (int)$_GET['set_id'] : 0;
$isPublic = isset($_GET['is_public']) ? (int)$_GET['is_public'] : 0;

// Fetch flashcards for the given set
$stmt = $mysqli->prepare("SELECT id, question, answer FROM flashcards WHERE set_id = ?");
if ($stmt) {
    $stmt->bind_param("i", $setId);
    $stmt->execute();
    $result = $stmt->get_result();
    $flashcards = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    die("Database query failed.");
}

// Function to clean Froala content for display
function cleanFroalaContent($html) {
    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    foreach ($dom->getElementsByTagName('*') as $element) {
        $element->removeAttribute('contenteditable');
        $element->removeAttribute('class');
        $element->removeAttribute('style');
    }
    return $dom->saveHTML($dom->getElementsByTagName('body')->item(0));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Flashcards</title>
    <link rel="stylesheet" href="style.css">
    <script>
        let setId = <?= json_encode($setId) ?>;
        let isPublic = <?= json_encode($isPublic) ?>;
        let flashcards = <?= json_encode($flashcards) ?>;
        let currentIndex = 0;
        let score = 0;

        function cleanHtmlDisplay(htmlContent) {
            let tempDiv = document.createElement('div');
            tempDiv.innerHTML = htmlContent;
            tempDiv.querySelectorAll('[contenteditable], .fr-wrapper, .fr-element').forEach(el => {
                el.removeAttribute('contenteditable');
                el.removeAttribute('class');
                el.removeAttribute('style');
            });
            return tempDiv.innerHTML.replace("Front cannot be empty.", "").trim();
        }

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
            let questionHtml = cleanHtmlDisplay(flashcards[currentIndex].question);
            document.getElementById('question').innerHTML = questionHtml;
            document.getElementById('user-answer').value = '';
        }

        function finishQuiz() {
            if (isPublic === 1) {
                fetch('save_score.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ set_id: setId, score: score })
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                    return response.json();
                })
                .then(result => {
                    alert(result.status === 'success' ? `Your score has been saved! Your score: ${score}` : `Failed to save score: ${result.message}`);
                    fetchLeaderboard();
                })
                .catch(error => {
                    console.error('Error saving score:', error);
                    alert('An error occurred while saving the score.');
                });
            } else {
                alert(`Your score: ${score}`);
            }
        }
        function reportFlashcard() {
    // If the flashcard set is not public, show an alert and return
    if (isPublic === 0) {
        alert("You can only report public flashcards.");
        return;
    }

    // Prompt the user to enter the reason for reporting
    let reportReason = prompt("Please enter the reason for reporting this flashcard:");

    if (!reportReason) {
        alert("Report reason is required.");
        return;
    }

    // Retrieve the flashcardId and setId from the flashcard data
    if (!flashcards || !setId) {
        alert("Unable to retrieve flashcard information for reporting.");
        return;
    }

    // Send the report to the backend
    fetch('report_flashcard.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            flashcard_id: flashcards[currentIndex].id,  // Send the flashcard id
            set_id: setId,
            reason: reportReason  // Send the reason for reporting
        })
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 'success') {
            alert("Report submitted successfully!");
        } else {
            alert("Error submitting the report: " + result.message);
        }
    })
    .catch(error => {
        console.error('Error reporting flashcard:', error);
    });
}





        function fetchLeaderboard() {
            fetch(`get_leaderboard.php?set_id=${setId}`)
            .then(response => response.json())
            .then(leaderboardData => {
                if (leaderboardData.status === 'success') {
                    displayLeaderboard(leaderboardData.leaderboard);
                }
            })
            .catch(error => console.error('Error fetching leaderboard:', error));
        }

        function displayLeaderboard(leaderboardData) {
            const leaderboardContainer = document.getElementById('leaderboard');
            leaderboardContainer.innerHTML = '';
            leaderboardData.forEach((entry, index) => {
                const leaderboardItem = document.createElement('li');
                leaderboardItem.textContent = `#${index + 1}: ${entry.username} - ${entry.score} points`;
                leaderboardContainer.appendChild(leaderboardItem);
            });
        }

        window.onload = function() {
            loadFlashcard();
            fetchLeaderboard();
        };
    </script>
</head>
<body>
    <div class="wrapper">
            <h1>Answer Flashcards</h1>
            <p id="question"></p>
            <input type="text" id="user-answer" placeholder="Enter your answer">
            <button onclick="checkAnswer()">Submit</button>
            <button id="report-button" onclick="reportFlashcard()">Report</button>
            <h2>Leaderboard</h2>
            <ul id="leaderboard"></ul>
            <a href="library.php">Back to Library</a>
        </div>
    </div>
</body>
</html>
