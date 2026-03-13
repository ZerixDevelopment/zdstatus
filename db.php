<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "status";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connectie mislukt: " . mysqli_connect_error());
}

// Zet charset naar utf8mb4 voor speciale karakters
mysqli_set_charset($conn, "utf8mb4");
?>