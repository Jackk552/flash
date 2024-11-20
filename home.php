<?php
    session_start();
    session_regenerate_id(true);    
    require 'connect.php'; 

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        header("Location: index.php");
        exit();
    }
    
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlashPoint</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
   <nav>
        <div class="container">
                <div class="card">
                    <a class="link" href="flashcards_manager.php"><h1>Flashcards Manager</h1></a>
                </div>
                <div class="card">
                    <a class="link" href="flashcardcreation.php"><h1>Create Flashcards</h1></a>
                </div>
                <div class="card">
                    <a class="link" href="library.php"><h1>Library</h1></a>
                </div>
                <div class="card">
                    <a href="logout.php" class="link"><h1>Logout</h1></a>
                </div>
        </div>
</nav>
</body>
</html>