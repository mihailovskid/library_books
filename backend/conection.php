<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=library', 'root', '',  [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
} catch (\PDOException $e) {
    echo 'Something went wrong.';
    die();
}

$servername = "127.0.0.1";
$username   = "root";
$password   = "";
$database   = "library";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
