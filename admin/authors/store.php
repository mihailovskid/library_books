<?php
session_start();

require __DIR__ . '../../check_if_user_has_access.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $biography = $_POST['biography'];

    $_SESSION['errors'] = [];

    // Validate inputs
    if (empty($firstname)) {
        $_SESSION['errors']['firstname'] = 'First name is required';
    }

    if (empty($lastname)) {
        $_SESSION['errors']['lastname'] = 'Last name is required';
    }

    if (strlen($biography) < 20) {
        $_SESSION['errors']['biography'] = 'Biography must be at least 20 characters';
    }

    if (!empty($_SESSION['errors'])) {
        header('Location: ./create.php?success=false');
        exit;
    }

    require_once __DIR__ . '../../../backend/conection.php';

    $stmt = $conn->prepare("INSERT INTO authors (firstname, lastname, biography) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $firstname, $lastname, $biography);

    if ($stmt->execute()) {
        $_SESSION['status'] = '<h3 class="text-success text-center">Author ' . $_POST['firstname'] . ' ' . $_POST['lastname'] . ' successfully created.</h3>';
        header('Location: ./index.php?success=true');
        exit;
    } else {
        $_SESSION['errors']['database'] = 'Error executing database query';
    }

    $stmt->close();
    $conn->close();
    exit;
}
