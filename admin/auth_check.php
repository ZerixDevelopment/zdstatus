<?php
session_start();
// Controleer of de sessievariabele 'admin' bestaat
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>