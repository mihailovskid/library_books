<?
session_start();
if (isset($_GET['success']) && $_GET['success'] === 'false')
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sign UP</title>
    <meta charset="utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <!-- Local CSS -->
    <link rel="stylesheet" href="./css/style.css" />
    <!-- Latest compiled and minified Bootstrap 4.4.1 CSS -->
    <link rel="stylesheet" href="./css/assets/bootstrap.min.css" />
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
                <a class="navbar-brand flex mx-lg-auto" href="index.php"><img src="./images/Logo.png" alt="logo image" class="logo d-block mx-auto mb-1">
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
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <div class="row mt-5">
                <div class="col-12 col-md-8 offset-md-2">
                    <h1 class="text-center">Register</h1>
                    <div class="text-danger">
                        <?php if (isset($_GET['empty_fields'])) : ?>
                            <p style="color: red"><?= $_GET['empty_fields'] ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <form action="./backend/register.php" method="POST" class="col-8 mx-auto">
                    <div class="mb-3">
                        <label class="form-label" for="username">Username</label>
                        <input class="form-control" type="text" id="username" placeholder="Username" name="username" required>
                        <div class="text-danger">
                            <?php if (isset($_GET['username_taken'])) : ?>
                                <p style="color: red"><?= $_GET['username_taken'] ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="pw">Password</label>
                        <input class="form-control" type="password" id="pw" placeholder="Password" name="password" required>
                        <div class="text-danger">
                            <?php if (isset($_GET['password_length'])) : ?>
                                <p style="color: red"><?= $_GET['password_length'] ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="config_pw">Password Confirmation</label>
                        <input class="form-control" type="password" id="config_pw" placeholder="Password Confirmation" name="password_confirmation" required>
                        <div class="text-danger">
                            <?php if (isset($_GET['password_mismatch'])) : ?>
                                <p style="color: red"><?= $_GET['password_mismatch'] ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
        </div>
    </main>
    <!-- jQuery library -->
    <script src="./js/jquery-3.5.1.min.js"></script>
    <!-- Latest Compiled Bootstrap 4.4.1 JavaScript -->
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</body>

</html>