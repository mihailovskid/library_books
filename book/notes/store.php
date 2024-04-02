<?php
session_start();

require_once __DIR__ . '../../../backend/conection.php';

$notes = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = 'INSERT INTO notes (user_id, book_id, note) VALUES (:user_id, :book_id, :note)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':book_id', $_POST['book_id'], PDO::PARAM_INT);
    $stmt->bindParam(':note', $_POST['note'], PDO::PARAM_STR);
    $stmt->execute();

    $sql = 'SELECT id, note FROM notes WHERE user_id = :user_id AND book_id = :book_id AND deleted_at IS NULL';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':book_id', $_POST['book_id'], PDO::PARAM_INT);
    $stmt->execute();
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode($notes);
