<?php
    session_start();
    session_regenerate_id(true);    
    include("connect.php");

    if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    // Now you can use $userId for database operations
    } else {
    // User is not logged in, handle accordingly (redirect, error message, etc.)
    header("Location: login.php"); // Redirect to login page
    exit;
    }require 'connect.php';  // Database connection file
    
    
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
                    <a class="link" href=""><h1>Home</h1></a>
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
</ul></nav>
<script src="index.js"></script>
</body>
</html>