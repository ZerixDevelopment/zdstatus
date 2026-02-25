<?php 
session_start(); 
include('../db.php'); 
if(!isset($_SESSION['admin'])) header('Location: login.php'); 

// Haal al het geplande onderhoud op
$maintenance = mysqli_query($conn, "SELECT * FROM maintenance ORDER BY scheduled_date ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maintenance Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 admin-sidebar">
            <h4 class="text-white px-3 mb-4">Status Admin</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="incidents.php">Incidents</a></li>
                <li class="nav-item"><a class="nav-link active" href="maintenance.php">Maintenance</a></li>
                <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                <li class="nav-item mt-5"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <main class="col-md-10 p-4">
            <div class="d-flex justify-content-between mb-4">
                <h2 class="text-white">Scheduled Maintenance</h2>
                <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#maintModal">+ Plan Maintenance</button>
            </div>

            <?php if(isset($_GET['msg'])) echo "<div class='alert alert-info py-2'>{$_GET['msg']}</div>"; ?>

            <div class="card p-3">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date & Time</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($maintenance) > 0): ?>
                            <?php while($m = mysqli_fetch_assoc($maintenance)): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($m['title']); ?></strong></td>
                                <td><?php echo date('d-m-Y H:i', strtotime($m['scheduled_date'])); ?></td>
                                <td class="text-secondary"><?php echo htmlspecialchars($m['description']); ?></td>
                                <td class="text-end">
                                    <a href="process.php?action=del_maint&id=<?php echo $m['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger" 
                                       onclick="return confirm('Remove this maintenance window?')">
                                       <i data-lucide="trash-2" style="width:16px;"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center text-secondary">No maintenance planned.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="maintModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="process.php?action=add_maint" method="POST" class="modal-content bg-dark text-white shadow-lg">
            <div class="modal-header border-secondary"><h5>Schedule New Maintenance</h5></div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Task Title</label>
                    <input type="text" name="title" class="form-control bg-dark text-white border-secondary" placeholder="e.g. Server Migration" required>
                </div>
                <div class="mb-3">
                    <label>Scheduled Date & Time</label>
                    <input type="datetime-local" name="date" class="form-control bg-dark text-white border-secondary" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control bg-dark text-white border-secondary" rows="3" placeholder="What will be done?"></textarea>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="submit" class="btn btn-info text-white w-100">Schedule Work</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>lucide.createIcons();</script>
</body>
</html>