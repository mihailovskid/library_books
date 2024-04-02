<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta charset="utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <!-- Local CSS -->
    <link rel="stylesheet" href="./css/style.css" type="text/css" />
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
                    <div class="mr-auto"></div>
                    <div class="form-inline my-2 my-lg-0">
                        <ul class="navbar-nav mr-auto text-center mx-auto">
                            <li class="nav-item nav--btn">
                                <a class="nav-link" href="register.php">Sign Up</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <main>
            <div class="container">
                <div class="row mt-5">
                    <div class="col-12 col-md-8 offset-md-2">
                        <div class="text-center mx-auto">
                            <h1 class="">Login</h1>
                        </div>
                        <form action="./backend/submit.php" method="POST">
                            <div class="text-danger">
                                <?php
                                if (isset($_GET['error'])) {
                                    $error = $_GET['error'];
                                    if ($error === 'empty') {
                                        echo '<p style="color: red">Username and password are required.</p>';
                                    } elseif ($error === 'invalid') {
                                        echo '<p style="color: red">Invalid username or password.</p>';
                                    }
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div id="show">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                    <div class="toggle-password">
                                        <input class="checkbox " type="checkbox" id="check">
                                        <label for="check" class="mb-0"><i class="fa-regular fa-eye"></i></label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </header>
    <style>
        #show {
            position: relative;
        }

        #password {
            width: 100%;
        }

        #show .toggle-password {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 10px;
            display: flex;
            align-items: center;
        }

        #show .checkbox {
            margin-right: 5px;
            visibility: hidden;
        }

        #show .fa-regular {
            cursor: pointer;
            color: #A9A9A9;
        }
    </style>
    <!-- jQuery library -->
    <script src="./js/jquery-3.5.1.min.js"></script>
    <!-- Latest Compiled Bootstrap 4.4.1 JavaScript -->
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/showPw.js"></script>

</body>

</html>