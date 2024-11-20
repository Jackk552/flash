<?php
session_start();
include 'connect.php';
session_regenerate_id(true);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch private flashcards with creator's username
$stmt = $mysqli->prepare("
    SELECT fs.id, fs.name, a.username 
    FROM flashcardsets fs
    JOIN accounts a ON fs.user_id = a.id
    WHERE fs.user_id = ? AND fs.is_public = 0
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$privateResult = $stmt->get_result();

// Fetch public flashcards with creator's username
$stmt = $mysqli->prepare("
    SELECT fs.id, fs.name, a.username 
    FROM flashcardsets fs
    JOIN accounts a ON fs.user_id = a.id
    WHERE fs.is_public = 1
");
$stmt->execute();
$publicResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flashcards Library</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <h1>Flashcards Library</h1>

        <section>
            <h2>Your Private Flashcards</h2>
            <?php if ($privateResult->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $privateResult->fetch_assoc()): ?>
                        <li>
                            <a href="answer_flashcards.php?set_id=<?= htmlspecialchars($row['id']) ?>&is_public=0">
                                <?= htmlspecialchars($row['name']) ?>
                            </a> 
                            - Created by: <?= htmlspecialchars($row['username']) ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No private flashcards found.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Public Flashcards</h2>
            <?php if ($publicResult->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $publicResult->fetch_assoc()): ?>
                        <li>
                            <a href="answer_flashcards.php?set_id=<?= htmlspecialchars($row['id']) ?>&is_public=1">
                                <?= htmlspecialchars($row['name']) ?>
                            </a> 
                            - Created by: <?= htmlspecialchars($row['username']) ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No public flashcards found.</p>
            <?php endif; ?>
        </section>

        <a href="home.php">Back to Home</a>
    </div>
</body>
</html>
