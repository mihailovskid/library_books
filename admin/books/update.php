<?php
session_start();

require __DIR__ . '../../check_if_user_has_access.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once __DIR__ . '../../../backend/conection.php';

    $params = [
        'title' => $_POST['title'],
        'author_id' => $_POST['author_id'],
        'year_published' => $_POST['year_published'],
        'pages' => $_POST['pages'],
        'img_url' => $_POST['img_url'],
        'category_id' => $_POST['category_id'],
        'id' => $_POST['book_id']
    ];
    $_SESSION['errors'] = [];

    if (empty($params['title'])) {
        $_SESSION['errors']['title'] = 'Title is reqired';
    }
    if (empty($params['author_id'])) {
        $_SESSION['errors']['author_id'] = 'Author is reqired';
    }
    if (empty($params['year_published'])) {
        $_SESSION['errors']['year_published'] = 'Year is reqired';
    }
    if (empty($params['pages'])) {
        $_SESSION['errors']['pages'] = 'Pages is reqired';
    }
    if (empty($params['img_url'])) {
        $_SESSION['errors']['img_url'] = 'img is reqired';
    }
    if (empty($params['category_id'])) {
        $_SESSION['errors']['category_id'] = 'Category is reqired';
    }

    if (empty($_SESSION['errors'])) {
        $sql = 'UPDATE books SET title = :title, author_id = :author_id, year_published = :year_published, pages = :pages, img_url = :img_url, category_id = :category_id WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute($params)) {
            $_SESSION['status'] = '<h3 class="text-success text-center">Book was successfully updated.</h3>';
            header('Location: ./index.php?success=true');
            exit();
        } else {
            $_SESSION['status'] = '<h3 class="text-danger text-center">Something went wrong</h3>';
            header('Location: ./edit.php');
            exit();
        }
    } else {
        $_SESSION['status'] = '<h3 class="text-danger text-center">All fields are required.</h3>';
        header('Location: ./edit.php');
        exit();
    }
}

header('Location: index.php');
$_SESSION['status'] = '<h3 class="text-danger text-center">Something went wrong</h3>';
die();
