<?php
// 1. Foutopsporing aan
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// 2. Database Gegevens
$host = "localhost";
$user = "root"; 
$pass = ""; 
$dbname = "calender"; 

// Verbinding maken
$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("<div style='color:red; padding:20px; border:2px solid red;'><strong>STOP:</strong> Database verbinding mislukt! Check of de database 'calender' wel bestaat in PHPMyAdmin. <br>Fout: " . mysqli_connect_error() . "</div>");
}

// 3. TABEL EN STANDAARD USER AANMAKEN (Automatisering)
// Maak de tabel als die niet bestaat
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50) UNIQUE, password VARCHAR(255))");

// Check of 'admin' al bestaat
$checkAdmin = mysqli_query($conn, "SELECT id FROM users WHERE username = 'admin'");
if (mysqli_num_rows($checkAdmin) == 0) {
    $hashedPass = password_hash('admin123', PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('admin', '$hashedPass')");
    $msg = "Standard user 'admin' created successfully!";
}

// 4. HAAL GEBRUIKERS OP
$users = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management Fix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; color: #1e293b; display: flex; min-height: 100vh; margin: 0; }
        .sidebar { width: 250px; background: white; border-right: 1px solid #e2e8f0; padding: 2rem 1rem; }
        .main-content { flex: 1; padding: 3rem; }
        .card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .nav-link { color: #64748b; padding: 10px; border-radius: 8px; text-decoration: none; display: block; }
        .nav-link.active { background: #f1f5f9; color: #0ea5e9; font-weight: bold; }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="text-primary fw-bold mb-4 px-2">Status Admin</h4>
    <nav class="nav flex-column">
        <a href="index.php" class="nav-link">Dashboard</a>
        <a href="services.php" class="nav-link">Services</a>
        <a href="incidents.php" class="nav-link">Incidents</a>
        <a href="maintenance.php" class="nav-link">Maintenance</a>
        <a href="users.php" class="nav-link active">Users</a>
        <a href="logout.php" class="nav-link text-danger mt-5">Logout</a>
    </nav>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">User Management</h2>
        <span class="text-muted">Manage your administrator accounts</span>
    </div>

    <?php if(isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>

    <div class="card p-0 overflow-hidden">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th class="px-4">Username</th>
                    <th class="text-end px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($users)): ?>
                <tr>
                    <td class="px-4 py-3 fw-semibold"><?php echo htmlspecialchars($row['username']); ?></td>
                    <td class="text-end px-4 py-3">
                        <a href="process.php?action=del_user&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger">Remove</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4 p-3 border rounded bg-white">
        <h5>Quick tip</h5>
        <p class="small text-muted mb-0">The default login is <strong>admin</strong> with password <strong>admin123</strong>. Once you're logged in, you can add other users here.</p>
    </div>
</div>

</body>
</html>