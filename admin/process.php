<?php
session_start();
include('../db.php');

// Beveiliging: alleen toegankelijk als ingelogd, behalve voor acties die we hieronder definiëren
if (!isset($_SESSION['admin'])) {
    die("Unauthorized access.");
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action) {
    // --- SERVICES ---
    case 'add_service':
        $n = mysqli_real_escape_string($conn, $_POST['name']);
        $t = $_POST['type'];
        $tg = mysqli_real_escape_string($conn, $_POST['target']);
        mysqli_query($conn, "INSERT INTO services (name, type, target, status) VALUES ('$n','$t','$tg', 'online')");
        header("Location: services.php?msg=Service added");
        break;

    case 'del_service':
        $id = intval($_GET['id']);
        mysqli_query($conn, "DELETE FROM services WHERE id=$id");
        header("Location: services.php?msg=Service deleted");
        break;

    case 'edit_service':
        $id = intval($_GET['id']);
        $n = mysqli_real_escape_string($conn, $_POST['name']);
        $s = $_POST['status'];
        mysqli_query($conn, "UPDATE services SET name='$n', status='$s' WHERE id=$id");
        header("Location: services.php?msg=Service updated");
        break;

    // --- INCIDENTS ---
    case 'add_incident':
        $t = mysqli_real_escape_string($conn, $_POST['title']);
        $d = mysqli_real_escape_string($conn, $_POST['description']);
        mysqli_query($conn, "INSERT INTO incidents (title, description) VALUES ('$t','$d')");
        header("Location: incidents.php?msg=Incident reported");
        break;

    case 'del_incident':
        $id = intval($_GET['id']);
        mysqli_query($conn, "DELETE FROM incidents WHERE id=$id");
        header("Location: incidents.php?msg=Incident removed");
        break;

    // --- MAINTENANCE ---
    case 'add_maint':
        $t = mysqli_real_escape_string($conn, $_POST['title']);
        $dt = $_POST['date'];
        $d = mysqli_real_escape_string($conn, $_POST['description']);
        mysqli_query($conn, "INSERT INTO maintenance (title, scheduled_date, description) VALUES ('$t','$dt', '$d')");
        header("Location: maintenance.php?msg=Maintenance scheduled");
        break;

    case 'del_maint':
        $id = intval($_GET['id']);
        mysqli_query($conn, "DELETE FROM maintenance WHERE id=$id");
        header("Location: maintenance.php?msg=Maintenance removed");
        break;

    // --- USERS ---
    case 'add_user':
        $u = mysqli_real_escape_string($conn, $_POST['username']);
        $p = password_hash($_POST['password'], PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$u', '$p')");
        header("Location: users.php?msg=User created");
        break;

    case 'del_user':
        $id = intval($_GET['id']);
        mysqli_query($conn, "DELETE FROM users WHERE id=$id");
        header("Location: users.php?msg=User deleted");
        break;

    default:
        header("Location: index.php");
        break;
        <?php
session_start();
include('../db.php');

$action = $_GET['action'] ?? '';

if($action == 'add_user') {
    $u = mysqli_real_escape_string($conn, $_POST['username']);
    $p = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$u', '$p')");
    header("Location: users.php?msg=UserAdded");
}

if($action == 'del_user') {
    $id = intval($_GET['id']);
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    header("Location: users.php?msg=UserDeleted");
}
?>