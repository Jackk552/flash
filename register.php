<?php
include 'connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Registration Process
if (isset($_POST['signUp'])) {   
    $first_name = $_POST['first_name'];
    $last_name = $_POST["last_name"];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPassword = md5($password); // Use password_hash() for better security

    // Check if username already exists
    $stmt = $mysqli->prepare("SELECT * FROM accounts WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists.";
    } else {   
        // Insert new account
        $stmt = $mysqli->prepare("INSERT INTO accounts (first_name, last_name, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $first_name, $last_name, $username, $hashedPassword);
        
        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

// Login Process
if (isset($_POST['signIn'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Use password_verify() instead of md5()

    // Correct SQL syntax
    $stmt = $mysqli->prepare("SELECT id, username, password FROM accounts WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            session_start(); // Start the session
            $row = $result->fetch_assoc();
            $_SESSION['username'] = $row['username']; // Store username
            $_SESSION['user_id'] = $row['id']; // Set user_id in the session

            echo "User found, redirecting...";
            header("Location: home.php");
            exit();
        } else {
            header("Location: index.php");
            exit();
        }
    } else {
        echo "Error executing query: " . $stmt->error;
    }
}
