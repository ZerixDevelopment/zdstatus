<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "status";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connectie mislukt: " . mysqli_connect_error());
}
?>