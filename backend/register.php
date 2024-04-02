<?php
session_start();
require_once __DIR__ . '/conection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;

    $username = trim($data['username']);
    $password = $data['password'];
    $password_confirmation = $data['password_confirmation'];

    $_SESSION['errors'] = [];

    // Validate input
    if (empty($username) || empty($password)) {
        $_SESSION['errors']['empty_fields'] = 'Username and password are required.';
    }

    if (strlen($password) < 8) {
        $_SESSION['errors']['password_length'] = 'Password must be at least 8 characters long.';
    }

    if ($password != $password_confirmation) {
        $_SESSION['errors']['password_mismatch'] = 'Password confirmation does not match.';
    }

    if (!empty($_SESSION['errors'])) {
        header('Location: ../register.php?success=false&' . http_build_query($_SESSION['errors']));
        exit;
    }

    // Check if the username already exists
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->fetch()) {
        $_SESSION['errors']['username_taken'] = 'Username is already taken.';
        header('Location: ../register.php?success=false&' . http_build_query($_SESSION['errors']));
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION['status'] = '<h3 class="text-success">User ' . $username . ' successfully created</h3>';
        header('Location: ../login.php');
        exit();
    } else {
        echo "Error registering user.";
    }
}
