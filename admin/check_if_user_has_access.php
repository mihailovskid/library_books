<?php

if (!isset($_SESSION['username'])) {
    header('Location: ../../login.php');
    exit();
}

if (!isset($_SESSION['is_admin'])) {
    header('Location: ../../index.php');
    exit();
}
