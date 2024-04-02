<?php
session_start();

unset($_SESSION['id']);
unset($_SESSION['is_admin']);
unset($_SESSION['username']);

session_destroy();

header('Location: ./index.php');
