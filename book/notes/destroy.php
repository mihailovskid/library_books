<?php
session_start();

require_once __DIR__ . '../../../backend/conection.php';

$notes = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $time = date('Y-m-d H:i:s');

    $sql = 'UPDATE notes SET deleted_at = :time WHERE id = :note_id AND user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':time', $time, PDO::PARAM_STR);
    $stmt->bindParam(':note_id', $_POST['note_id'], PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();

    $sql = 'SELECT id, note FROM notes WHERE user_id = :user_id AND book_id = :book_id AND deleted_at IS NULL';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':book_id', $_POST['book_id'], PDO::PARAM_INT);
    $stmt->execute();
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode($notes);
