<?php
session_start();

require_once __DIR__ . '../../backend/conection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['comment_text']) && isset($_POST['book_id'])) {
            $commentText = $_POST['comment_text'];
            $bookId = $_POST['book_id'];
            $userId = $_SESSION['user_id'];

            $_SESSION['errors'] = [];

            if (strlen($commentText) < 10) {
                $_SESSION['errors']['comment_text'] = 'Comment must be at least 10 characters long.';
                header('Location: book.php?id=' . $bookId);
                exit();
            }

            // Check if the user has already commented on this book
            $sql = 'SELECT * FROM comments WHERE user_id = :user_id AND book_id = :book_id AND deleted_at IS NULL';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $stmt->execute();

            $existingComment = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$existingComment) {
                $sql = 'INSERT INTO comments (user_id, book_id, comment, status) VALUES (:user_id, :book_id, :comment_text, NULL)';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
                $stmt->bindParam(':comment_text', $commentText, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    // Redirect only if the comment was successfully inserted
                    header('Location: book.php?id=' . $bookId);
                    exit();
                } else {
                    echo "Error";
                }
            } else {
                // The user has already commented on this book
                echo "Error: You can only make one comment per book.";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

header('Location: book.php?id=' . $bookId);
exit();
