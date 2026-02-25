<?php session_start(); include('../db.php'); if(!isset($_SESSION['admin'])) header('Location: login.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<div class="container-fluid"><div class="row">
    <nav class="col-md-2 admin-sidebar">
        <h4 class="text-white px-3 mb-4">Status Admin</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
            <li class="nav-item"><a class="nav-link active" href="incidents.php">Incidents</a></li>
            <li class="nav-item"><a class="nav-link" href="maintenance.php">Maintenance</a></li>
            <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
        </ul>
    </nav>

    <main class="col-md-10 p-4">
        <h3 class="text-white mb-4">Report New Incident</h3>
        
        <form action="process.php?action=add_incident" method="POST" class="card p-4 mb-4 shadow">
            <div class="mb-3">
                <label class="text-white">Incident Title</label>
                <input type="text" name="title" class="form-control bg-dark text-white border-secondary" placeholder="e.g., Database Connection Issues" required>
            </div>
            <div class="mb-3">
                <label class="text-white">Description</label>
                <textarea name="description" class="form-control bg-dark text-white border-secondary" rows="3" placeholder="Describe the issue..."></textarea>
            </div>
            <button type="submit" class="btn btn-danger w-100">Post Incident</button>
        </form>

        <div class="card p-3">
            <h5 class="text-white mb-3">Incident History</h5>
            <table class="table table-dark">
                <?php
                $res = mysqli_query($conn, "SELECT * FROM incidents ORDER BY created_at DESC");
                while($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                        <td>{$row['title']}</td>
                        <td class='text-secondary'>{$row['created_at']}</td>
                        <td class='text-end'>
                            <a href='process.php?action=del_incident&id={$row['id']}' class='btn btn-sm btn-outline-danger'>
                                <i data-lucide='trash-2' style='width:16px;'></i>
                            </a>
                        </td>
                    </tr>";
                }
                ?>
            </table>
        </div>
    </main>
</div></div>
<script>lucide.createIcons();</script>
</body></html>