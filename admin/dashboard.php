<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

if (!isset($_SESSION['is_admin'])) {
    header('Location: ../index.php');
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <meta charset="utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <!-- Local CSS -->
    <link rel="stylesheet" href="../css/style.css" />
    <!-- Latest compiled and minified Bootstrap 4.4.1 CSS -->
    <link rel="stylesheet" href="../css/assets/bootstrap.min.css" />
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
                <a class="navbar-brand flex mx-lg-auto" href="../index.php"><img src="../images/Logo.png" alt="logo image" class="logo d-block mx-auto mb-1">
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
                                <a class="nav-link" href="../logout.php">Sign out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <div class="mt-3 mb-5">
            <a href="./dashboard.php">Home</a>
        </div>
        <div class="text-danger">
            <?php
            if (isset($_GET['message'])) {
                $error = $_GET['message'];
                if ($error === 'Welcome') {
                    echo '<h2 class="text-center mb-3" style="color: green">Welcome!</h2>';
                }
            }
            ?>
        </div>
        <table class="table">
            <tbody>
                <tr>
                    <td>
                        <a href="./authors/index.php">
                            <h4 class="mb-0">Authors</h4>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="./categories/index.php">
                            <h4 class="mb-0">Categories</h4>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="./books/index.php">
                            <h4 class="mb-0">Books</h4>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="./comments/index.php">
                            <h4 class="mb-0">Comments</h4>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- jQuery library -->
    <script src="./js/jquery-3.5.1.min.js"></script>
    <!-- Latest Compiled Bootstrap 4.4.1 JavaScript -->
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</body>

</html>