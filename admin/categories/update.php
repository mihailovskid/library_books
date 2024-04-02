<?php
session_start();

require __DIR__ . '../../check_if_user_has_access.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['title'])) {
        $_SESSION['status'] = '<h3 class="text-danger text-center">Category title cannot be empty.</h3>';
        header('Location: edit.php');
        die();
    }
    require_once __DIR__ . '../../../backend/conection.php';

    $params = [
        'title' => $_POST['title'],
        'id' => $_POST['category_id']
    ];

    $sql = 'UPDATE categories SET title = :title WHERE id = :id';

    $stmt = $pdo->prepare($sql);

    if ($stmt->execute($params)) {
        $_SESSION['status'] = '<h3 class="text-success text-center">Category title successfully updated.</h3>';
    } else {
        $_SESSION['status'] = '<h3 class="text-danger text-center">Something went wrong</h3>';
    }
}

header('Location: index.php');
die();
