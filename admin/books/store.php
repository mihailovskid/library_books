<?php
session_start();

require __DIR__ . '../../check_if_user_has_access.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $author_id = isset($_POST['author_id']) ? $_POST['author_id'] : '';
    $year_published = isset($_POST['year_published']) ? $_POST['year_published'] : '';
    $pages = isset($_POST['pages']) ? $_POST['pages'] : '';
    $img_url = isset($_POST['img_url']) ? $_POST['img_url'] : '';
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';

    $_SESSION['errors'] = [];

    // Validate inputs
    if (empty($title)) {
        $_SESSION['errors']['title'] = 'Title is required';
    }

    if (empty($author_id)) {
        $_SESSION['errors']['author_id'] = 'Author is required';
    }

    if (empty($year_published)) {
        $_SESSION['errors']['year_published'] = 'Year is required';
    }

    if (empty($pages)) {
        $_SESSION['errors']['pages'] = 'Pages is required';
    }

    if (empty($img_url)) {
        $_SESSION['errors']['img_url'] = 'Image is required';
    }

    if (empty($_SESSION['errors'])) {
        require_once __DIR__ . '../../../backend/conection.php';

        $stmt = $conn->prepare("INSERT INTO books (title, author_id, year_published, pages, img_url, category_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiisi", $title, $author_id, $year_published, $pages, $img_url, $category_id);

        if ($stmt->execute()) {
            $_SESSION['status'] = '<h3 class="text-success text-center">Book successfully created.</h3>';
            header('Location: ./index.php?success=true');
            exit;
        } else {
            $_SESSION['errors']['database'] = 'Error executing database query';
        }

        $stmt->close();
        $conn->close();
        exit;
    }
}
header('Location: ./create.php');
$_SESSION['status'] = '<h3 class="text-danger text-center">All fields are required.</h3>';
exit;
