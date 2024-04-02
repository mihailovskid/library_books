<?php
require_once __DIR__ . '/conection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;

    $username = trim($data['username']);
    $password = $data['password'];

    if (empty($username) || empty($password)) {
        header('Location: ../login.php?error=empty');
        exit;
    }

    // Retrieve the hashed password from the database based on the provided username
    $query = "SELECT id, username, password, is_admin FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    // Verify the password
    if ($user && password_verify($password, $user['password'])) {
        // Start a session and store user information if needed
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        if ($user['is_admin']) {
            $_SESSION['is_admin'] = $user['is_admin'];
        }

        if ($user['is_admin']) {
            header('Location: ../admin/dashboard.php?message=Welcome');
        } else {
            header('Location: ../index.php');
        }
        exit();
    } else {
        header('Location: ../login.php?error=invalid');
    }
}
