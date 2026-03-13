<?php
session_start();
include('../db.php');
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u = mysqli_real_escape_string($conn, $_POST['username']);
    $p = $_POST['password'];

    $res = mysqli_query($conn, "SELECT * FROM users WHERE gebruikersnaam = '$u' LIMIT 1");

    if ($row = mysqli_fetch_assoc($res)) {
        if (password_verify($p, $row['wachtwoord']) || $p === $row['wachtwoord']) {
            $_SESSION['admin'] = $row['gebruikersnaam'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <title>Admin Login</title>
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh; background: #f8fafc;">
    <div class="card p-4 shadow-sm" style="max-width: 400px; width:100%;">
        <h3 class="text-center fw-bold mb-4">Login</h3>
        <?php if($error): ?> <div class="alert alert-danger py-2 small text-center"><?php echo $error; ?></div> <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </form>
    </div>
</body>
</html>