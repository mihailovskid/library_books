<?php
session_start();

require __DIR__ . '../../check_if_user_has_access.php';

require_once __DIR__ . '../../../backend/conection.php';

$sql = 'SELECT books.id, books.title, books.year_published, books.pages, books.img_url, authors.firstname 
AS author_firstname, authors.lastname AS author_lastname, categories.title AS category_title
FROM books JOIN authors ON books.author_id = authors.id JOIN categories ON books.category_id = categories.id WHERE books.deleted_at IS NULL';

$books = $pdo->query($sql);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Books</title>
    <meta charset="utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <!-- Local CSS -->
    <link rel="stylesheet" href="../../css/style.css" />
    <!-- Latest compiled and minified Bootstrap 4.4.1 CSS -->
    <link rel="stylesheet" href="../../css/assets/bootstrap.min.css" />
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- custom font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <!-- Latest Font-Awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/3b2a155ba0.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg--nav px-5 w-100">
            <div class="container">
                <a class="navbar-brand flex mx-lg-auto" href="../../index.php"><img src="../../images/Logo.png" alt="logo image" class="logo d-block mx-auto mb-1">
                    <p class="mb-0 font-weight-bold text-uppercase h6">brainster</p>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class=" mr-auto"></div>
                    <div class="form-inline my-2 my-lg-0">
                        <ul class="navbar-nav mr-auto text-center mx-auto">
                            <li class="nav-item nav--btn">
                                <a class="nav-link" href="../../logout.php">Sign out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <div class="d-flex justify-content-between mt-2">
            <div class="mt-2 mb-5">
                <a href="../dashboard.php"> Home </a> / Books
            </div>
            <div>
                <a class="btn btn-success" href="./create.php"><i class="fas fa-plus pr-2"></i>Create</a>
            </div>
        </div>
        <?php
        require "../status_messages.php";
        ?>
        <div class="row px-3">
            <table class="table col mx-auto">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Year</th>
                        <th scope="col">Pages</th>
                        <th scope="col">Img URL</th>
                        <th scope="col">Category</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $books->fetch()) { ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['title'] ?></td>
                            <td><?= $row['author_firstname'] . ' ' . $row['author_lastname'] ?></td>
                            <td><?= $row['year_published'] ?></td>
                            <td><?= $row['pages'] ?></td>
                            <td><?= $row['img_url'] ?></td>
                            <td><?= $row['category_title'] ?></td>
                            <td>
                                <a class="d-inline-block" href="./edit.php?id=<?= $row['id'] ?>"><i class="fas fa-pen-to-square text-warning"></i></a>
                                <form class="d-inline-block" action="./destroy.php" method="POST">
                                    <input type="hidden" value="<?= $row['id'] ?>" name="id">
                                    <button class="btn d-inline-block delete-button" data-item-id="<?= $row['id'] ?>" data-item-type="Book">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>

                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery library -->
    <script src="../../js/jquery-3.5.1.min.js"></script>
    <!-- Latest Compiled Bootstrap 4.4.1 JavaScript -->
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('body').on('click', '.delete-button', function(event) {
                event.preventDefault();

                var itemId = $(this).data('item-id');
                var itemType = $(this).data('item-type');

                console.log("Item ID:", itemId);
                console.log("Item Type:", itemType);

                Swal.fire({
                    title: "Are you sure?",
                    text: "deleting this " + itemType + " deletes all user comments and notes You want to delete the ",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('form').submit();
                    }
                });
            });
        });
    </script>
</body>

</html>