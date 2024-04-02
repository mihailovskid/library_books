<?php
session_start();

require_once __DIR__ . '../../backend/conection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentId = $_POST['id'];
    $userId = $_SESSION['user_id'];

    $sql = 'SELECT * FROM comments WHERE id = :comment_id AND user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($comment) {
        $sql = 'DELETE FROM comments WHERE id = :comment_id';
        $sql = $pdo->prepare($sql);
        $sql->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
        $sql->execute();

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header('Location: book.php?id=' . $bookId);
        exit();
    }
} else {
    header('Location: book.php?id=' . $bookId);
    exit();
}
