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

$userId = $_SESSION['user_id'];

// Fetch flashcard sets created by the logged-in user
$stmt = $mysqli->prepare("SELECT id, name FROM flashcardsets WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$flashcardSetsResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flashcards Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <h1>Your Flashcards</h1>
        
        <?php if ($flashcardSetsResult->num_rows > 0): ?>
            <ul>
                <?php while ($row = $flashcardSetsResult->fetch_assoc()): ?>
                    <li>
                        <h2><?= htmlspecialchars($row['name']) ?></h2>
                        <a href="delete_flashcard_set.php?set_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this set?')">Delete</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>You haven't created any flashcard sets yet.</p>
        <?php endif; ?>
        <a href="home.php">Back</a>
    </div>
</body>
</html>
