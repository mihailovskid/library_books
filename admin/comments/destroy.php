<?php
session_start();

require __DIR__ . '../../check_if_user_has_access.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once __DIR__ . '../../../backend/conection.php';

    $params = [
        'deleted_at' => date("Y-m-d H:i:s"),
        'id' => $_POST['id']
    ];

    $sql = 'UPDATE comments SET deleted_at = :deleted_at WHERE id = :id';

    $stmt = $pdo->prepare($sql);

    if ($stmt->execute($params)) {
        $_SESSION['status'] = '<h3 class="text-success text-center">Comment was successfully deleted.</h3>';
    } else {
        $_SESSION['status'] = '<h3 class="text-danger text-center">Something went wrong</h3>';
    }
}

header('Location: index.php');
die();
