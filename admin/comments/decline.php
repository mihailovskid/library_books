<?php
session_start();

require __DIR__ . '../../check_if_user_has_access.php';

require_once __DIR__ . '../../../backend/conection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $commentId = $_GET['id'];

    try {
        $sql = "UPDATE comments SET status = 2 WHERE id = :commentId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':commentId', $commentId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Decline';
        } else {
            $_SESSION['error'] = 'Error approving the comment.';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Database error: ' . $e->getMessage();
    }
}

header('Location: index.php');
exit();
