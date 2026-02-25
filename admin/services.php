<?php 
session_start(); 
include('../db.php'); 
if(!isset($_SESSION['admin'])) header('Location: login.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Services Management | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Extra fix om alle zwarte elementen te overschrijven */
        body { background-color: #f8fafc !important; color: #1e293b !important; }
        .table { background-color: #ffffff !important; color: #1e293b !important; }
        .table thead th { background-color: #f1f5f9 !important; color: #475569 !important; border-bottom: 1px solid #e2e8f0; }
        .card { background-color: #ffffff !important; border: 1px solid #e2e8f0 !important; }
        .modal-content { background-color: #ffffff !important; color: #1e293b !important; }
        code { background-color: #f1f5f9; color: #e11d48; padding: 2px 4px; border-radius: 4px; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 admin-sidebar shadow-sm">
            <h4 class="fw-bold mb-4 px-3 text-primary">Status Admin</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="index.php"><i data-lucide="layout-dashboard" class="me-2" style="width:18px"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="services.php"><i data-lucide="server" class="me-2" style="width:18px"></i> Services</a></li>
                <li class="nav-item"><a class="nav-link" href="incidents.php"><i data-lucide="alert-circle" class="me-2" style="width:18px"></i> Incidents</a></li>
                <li class="nav-item"><a class="nav-link" href="maintenance.php"><i data-lucide="calendar" class="me-2" style="width:18px"></i> Maintenance</a></li>
                <li class="nav-item"><a class="nav-link" href="users.php"><i data-lucide="users" class="me-2" style="width:18px"></i> Users</a></li>
                <li class="nav-item mt-5"><a class="nav-link text-danger" href="logout.php"><i data-lucide="log-out" class="me-2" style="width:18px"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark">Services</h2>
                <button class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i data-lucide="plus" class="me-1" style="width:18px"></i> New Service
                </button>
            </div>

            <div class="card shadow-sm border-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4">Service Name</th>
                                <th>Target</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = mysqli_query($conn, "SELECT * FROM services ORDER BY name ASC");
                            if(mysqli_num_rows($res) > 0):
                                while($row = mysqli_fetch_assoc($res)):
                                    $is_online = ($row['status'] == 'online');
                            ?>
                            <tr>
                                <td class="ps-4 fw-bold text-dark"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><code><?php echo htmlspecialchars($row['target']); ?></code></td>
                                <td>
                                    <span class="status-dot <?php echo $is_online ? 'dot-online' : 'dot-offline'; ?>"></span>
                                    <span class="fw-bold <?php echo $is_online ? 'text-success' : 'text-danger'; ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="process.php?action=del_service&id=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger border-0" 
                                       onclick="return confirm('Delete this service?')">
                                        <i data-lucide="trash-2" style="width:18px"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; else: ?>
                            <tr><td colspan="4" class="text-center py-5 text-muted">No services found. Add one to start monitoring.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="process.php?action=add_service" method="POST" class="modal-content shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Add Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="name" class="form-control mb-3" placeholder="Service Name (e.g. Webserver)" required>
                <select name="type" class="form-select mb-3">
                    <option value="website">Website (HTTP)</option>
                    <option value="ip">IP Address (Ping)</option>
                </select>
                <input type="text" name="target" class="form-control" placeholder="URL or IP Address" required>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 py-2">Add Service</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>lucide.createIcons();</script>
</body>
</html>