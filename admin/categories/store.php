<?php
session_start();

require __DIR__ . '../../check_if_user_has_access.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];

    $_SESSION['errors'] = [];

    // Validate inputs
    if (empty($title)) {
        $_SESSION['errors']['title'] = 'Category title is required';
    }


    if (!empty($_SESSION['errors'])) {
        header('Location: ./create.php?success=false');
        exit;
    }

    require_once __DIR__ . '../../../backend/conection.php';

    $stmt = $conn->prepare("INSERT INTO categories (title) VALUES (?)");
    $stmt->bind_param("s", $title);

    if ($stmt->execute()) {
        $_SESSION['status'] = '<h3 class="text-success text-center">Category Title successfully created.</h3>';

        header('Location: ./index.php?success=true');
        exit;
    } else {
        $_SESSION['errors']['database'] = 'Error executing database query';
    }

    $stmt->close();
    $conn->close();
    exit;
}
