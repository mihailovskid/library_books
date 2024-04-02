<?php
session_start();

require __DIR__ . '../../check_if_user_has_access.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once __DIR__ . '../../../backend/conection.php';

    $params = [
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'biography' => $_POST['biography'],
        'id' => $_POST['author_id']
    ];

    $_SESSION['errors'] = [];

    // Validate inputs
    if (empty($params['firstname'])) {
        $_SESSION['errors']['firstname'] = 'First name cannot be empty';
    }

    if (empty($params['lastname'])) {
        $_SESSION['errors']['lastname'] = 'Last name cannot be empty';
    }

    if (strlen($params['biography']) < 20) {
        $_SESSION['errors']['biography'] = 'Biography must be at least 20 characters long';
    }

    if (!empty($_SESSION['errors'])) {
        header('Location: ./edit.php?success=false');
        exit;
    }

    $sql = 'UPDATE authors SET firstname = :firstname, lastname = :lastname, biography = :biography WHERE id = :id';

    $stmt = $pdo->prepare($sql);

    if ($stmt->execute($params)) {
        $_SESSION['status'] = '<h3 class="text-success text-center">Author ' . $params['firstname'] . ' ' . $params['lastname'] . ' successfully updated.</h3>';
    } else {
        $_SESSION['status'] = '<h3 class="text-danger text-center">Something went wrong</h3>';
    }
}

header('Location: index.php?success=true');
die();
