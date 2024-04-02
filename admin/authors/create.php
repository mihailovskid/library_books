<?php
session_start();

require __DIR__ . '../../check_if_user_has_access.php';

$success = isset($_GET['success']) ? $_GET['success'] : null;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Create Authors</title>
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
                            <li class="nav-item nav--btn mr-lg-4 mb-3 mb-lg-0 mt-3 mt-lg-0">
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
                <a href="../dashboard.php"> Home </a> / <a href="index.php"> Authors </a> / Create
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <?php if ($success == 'true') : ?>
                        <h1 style="color: green">Successfully</h1>
                    <?php elseif ($success == 'false') : ?>
                        <h1 style="color: red">Something went wrong</h1>
                    <?php endif;
                    ?>
                </div>
                <form class=" mx-auto bg--form p-5 rounded" method="POST" action="store.php">
                    <h2 class="mb-4 text-center">Create new Author</h2>
                    <div class="form-group">
                        <label for="firstname" require>First name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname">
                        <?php if (!empty($_SESSION['errors']['firstname'])) : ?>
                            <p style="color: red"><?= $_SESSION['errors']['firstname'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="lastname" require>Last name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname">
                        <?php if (!empty($_SESSION['errors']['lastname'])) : ?>
                            <p style="color: red"><?= $_SESSION['errors']['lastname'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="biography" require>Biography</label>
                        <textarea class="form-control" id="biography" rows="3" name="biography"></textarea>
                        <?php if (!empty($_SESSION['errors']['biography'])) : ?>
                            <p style="color: red"><?= $_SESSION['errors']['biography'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="justify-content-between d-flex">
                        <a class="btn btn-danger text-white" href="./index.php">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- jQuery library -->
    <script src="../../js/jquery-3.5.1.min.js"></script>
    <!-- Latest Compiled Bootstrap 4.4.1 JavaScript -->
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
</body>

</html>