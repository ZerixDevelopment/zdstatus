<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add_service':
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $target = mysqli_real_escape_string($conn, $_POST['target']);
        mysqli_query($conn, "INSERT INTO services (name, type, target, status) VALUES ('$name', '$type', '$target', 'online')");
        header("Location: services.php");
        break;

    case 'del_service':
        $id = (int)$_GET['id'];
        mysqli_query($conn, "DELETE FROM services WHERE id = $id");
        header("Location: services.php");
        break;

    case 'add_incident':
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $desc = mysqli_real_escape_string($conn, $_POST['description']);
        mysqli_query($conn, "INSERT INTO incidents (title, description) VALUES ('$title', '$desc')");
        header("Location: incidents.php");
        break;

    case 'del_incident':
        $id = (int)$_GET['id'];
        mysqli_query($conn, "DELETE FROM incidents WHERE id = $id");
        header("Location: incidents.php");
        break;

    case 'add_user':
        $user = mysqli_real_escape_string($conn, $_POST['username']);
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users (gebruikersnaam, wachtwoord) VALUES ('$user', '$pass')");
        header("Location: users.php");
        break;

    case 'del_user':
        $id = (int)$_GET['id'];
        mysqli_query($conn, "DELETE FROM users WHERE id = $id");
        header("Location: users.php");
        break;

    default:
        header("Location: index.php");
        break;
}