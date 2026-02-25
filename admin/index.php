<?php
session_start();
include('../db.php');
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 admin-sidebar">
            <h4 class="text-white px-3">Status Admin</h4>
            <div class="nav flex-column nav-pills mt-4" id="v-pills-tab" role="tablist">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#services">Services</button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#incidents">Incidents</button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#maintenance">Maintenance</button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#users">Users</button>
                <a href="logout.php" class="nav-link text-danger mt-5">Logout</a>
            </div>
        </nav>

        <main class="col-md-10 p-4">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="services">
                    <div class="d-flex justify-content-between mb-4">
                        <h3>Service Monitoring</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">+ New Service</button>
                    </div>
                    <div class="card p-3">
                        <table class="table table-dark table-hover">
                            <thead><tr><th>Name</th><th>Target</th><th>Status</th><th>Actions</th></tr></thead>
                            <tbody>
                                <?php
                                $res = mysqli_query($conn, "SELECT * FROM services");
                                while($row = mysqli_fetch_assoc($res)) {
                                    $dot = ($row['status'] == 'online') ? 'dot-online' : 'dot-offline';
                                    echo "<tr>
                                        <td>{$row['name']}</td>
                                        <td><code>{$row['target']}</code></td>
                                        <td><span class='status-dot $dot'></span> ".ucfirst($row['status'])."</td>
                                        <td>
                                            <a href='edit.php?type=service&id={$row['id']}' class='btn btn-sm btn-outline-info'>Edit</a>
                                            <a href='process.php?action=del_service&id={$row['id']}' class='btn btn-sm btn-outline-danger'>Delete</a>
                                        </td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="incidents">
                    <h3>Report Incident</h3>
                    <form action="process.php?action=add_incident" method="POST" class="card p-3 mb-4">
                        <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>
                        <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
                        <button type="submit" class="btn btn-danger">Post Incident</button>
                    </form>
                    <div class="card p-3">
                        <?php
                        $res = mysqli_query($conn, "SELECT * FROM incidents ORDER BY id DESC");
                        while($row = mysqli_fetch_assoc($res)) {
                            echo "<div class='d-flex justify-content-between border-bottom border-secondary py-2'>
                                    <span>{$row['title']} <small class='text-secondary'>({$row['created_at']})</small></span>
                                    <a href='process.php?action=del_incident&id={$row['id']}' class='text-danger'><i data-lucide='trash-2'></i></a>
                                  </div>";
                        }
                        ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="maintenance">
                    <h3>Schedule Maintenance</h3>
                    <form action="process.php?action=add_maint" method="POST" class="card p-3 mb-4">
                        <input type="text" name="title" class="form-control mb-2" placeholder="Maintenance Title" required>
                        <input type="datetime-local" name="date" class="form-control mb-2" required>
                        <textarea name="description" class="form-control mb-2" placeholder="Details"></textarea>
                        <button type="submit" class="btn btn-info text-white">Schedule</button>
                    </form>
                    <div class="card p-3">
                        <?php
                        $res = mysqli_query($conn, "SELECT * FROM maintenance");
                        while($row = mysqli_fetch_assoc($res)) {
                            echo "<div class='d-flex justify-content-between py-2 border-bottom border-secondary'>
                                    <span><strong>{$row['title']}</strong> - {$row['scheduled_date']}</span>
                                    <div>
                                        <a href='edit.php?type=maint&id={$row['id']}' class='text-info me-2'>Edit</a>
                                        <a href='process.php?action=del_maint&id={$row['id']}' class='text-danger'>Delete</a>
                                    </div>
                                  </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="addServiceModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="process.php?action=add_service" method="POST" class="modal-content bg-dark text-white">
      <div class="modal-header border-secondary"><h5 class="modal-title">Add New Service</h5></div>
      <div class="modal-body">
        <input type="text" name="name" class="form-control mb-2" placeholder="Service Name" required>
        <select name="type" class="form-select mb-2"><option value="website">Website URL</option><option value="ip">IP Address</option></select>
        <input type="text" name="target" class="form-control mb-2" placeholder="e.g. 1.1.1.1 or https://google.com" required>
      </div>
      <div class="modal-footer border-secondary"><button type="submit" class="btn btn-primary">Save Service</button></div>
    </form>
  </div>
</div>

<script>lucide.createIcons();</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>