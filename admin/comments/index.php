<?php
session_start();

require __DIR__ . '../../check_if_user_has_access.php';

require_once __DIR__ . '../../../backend/conection.php';

$status = null;
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

$status_query = "";

if ($status === null || $status == "") {
    $status_query = " AND c.status IS NULL";
} elseif ($status == 1) {
    $status_query = " AND c.status = 1";
} elseif ($status == 2) {
    $status_query = " AND c.status = 2";
}

$sql = "SELECT c.id, u.username AS user_name, b.title AS book_title, c.comment, c.status, c.deleted_at 
FROM comments c JOIN users u ON c.user_id = u.id JOIN books b ON c.book_id = b.id WHERE c.deleted_at IS NULL{$status_query}";

$comments = $pdo->query($sql);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Comments</title>
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
                <a href="../dashboard.php">Home</a> / Comments
            </div>
            <div>
                Filter by Status
                <form class="form-inline" action="" method="GET">
                    <div>
                        <select class="form-control d-inline-block" name="status" id="status">
                            <option value="0" <?php if ($status == 0) { ?> selected <?php } ?>>All</option>
                            <option value="1" <?php if ($status == 1) { ?> selected <?php } ?>>Approved</option>
                            <option value="2" <?php if ($status == 2) { ?> selected <?php } ?>>Declined</option>
                            <option value="" <?php if ($status === null || $status == "") { ?> selected <?php } ?>>Pending</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info ml-2">Filter</button>
                </form>
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
                        <th scope="col">Comment</th>
                        <th scope="col">User</th>
                        <th scope="col">Book Title</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($comments->fetchAll() as $comment) { ?>
                        <tr>
                            <td><?= $comment['id'] ?></td>
                            <td class="w-50"><?= $comment['comment'] ?></td>
                            <td><?= $comment['user_name'] ?></td>
                            <td><?= $comment['book_title'] ?></td>
                            <td>
                                <?php
                                if ($comment['status'] == null) {
                                    echo 'Pending';
                                } elseif ($comment['status'] == 1) {
                                    echo 'Approved';
                                } elseif ($comment['status'] == 2) {
                                    echo 'Declined';
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <a class="d-inline-block mr-2" href="./approve.php?id=<?= $comment['id'] ?>"><i class="fa-solid fa-check text-success"></i></a>
                                <a class="d-inline-block mr-2" href="./decline.php?id=<?= $comment['id'] ?>"><i class="fa-solid fa-xmark text-warning"></i></a>
                                <form class="d-inline-block p-0" action="./destroy.php" method="POST">
                                    <input type="hidden" value="<?= $comment['id'] ?>" name="id">
                                    <button class="btn d-inline-block delete-button" data-item-type="Comment" data-item-id="<?= $row['id'] ?>">
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
                    text: "You want to delete the " + itemType + "?",
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