<?php 
session_start(); 
include('../db.php'); 
if(!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); } 

// Fetch some quick stats
$total_services = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM services"));
$offline_services = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM services WHERE status = 'offline'"));
$active_incidents = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM incidents"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Status Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<div class="container-fluid"><div class="row">
    <?php include('navbar.php'); ?>
    <main class="col-md-10 p-5">
        <h2 class="fw-bold mb-4">Dashboard</h2>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4">
                    <div class="text-muted small fw-bold text-uppercase">Total Services</div>
                    <div class="h2 fw-bold mb-0"><?php echo $total_services; ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4">
                    <div class="text-muted small fw-bold text-uppercase">Currently Offline</div>
                    <div class="h2 fw-bold mb-0 <?php echo ($offline_services > 0) ? 'text-danger' : 'text-success'; ?>">
                        <?php echo $offline_services; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4">
                    <div class="text-muted small fw-bold text-uppercase">Active Incidents</div>
                    <div class="h2 fw-bold mb-0"><?php echo $active_incidents; ?></div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h4 class="fw-bold mb-3">Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?>!</h4>
            <p class="text-muted">Use the sidebar to manage your services, track incidents, or add new administrators.</p>
        </div>
    </main>
</div></div>
<script>lucide.createIcons();</script>
</body></html>