<?php session_start(); include('../db.php'); if(!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<div class="container-fluid"><div class="row">
    <?php include('navbar.php'); ?>
    <main class="col-md-10 p-5">
        <div class="d-flex justify-content-between mb-4">
            <h2 class="fw-bold">Services</h2>
            <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#addS">Add New Service</button>
        </div>
        <div class="card border-0 shadow-sm"><table class="table mb-0">
            <thead><tr><th class="ps-4">Name</th><th>Target</th><th>Status</th><th class="text-end pe-4">Action</th></tr></thead>
            <tbody>
                <?php $res = mysqli_query($conn, "SELECT * FROM services"); while($s = mysqli_fetch_assoc($res)): ?>
                <tr>
                    <td class="ps-4 fw-bold"><?php echo htmlspecialchars($s['name']); ?></td>
                    <td><?php echo htmlspecialchars($s['target']); ?></td>
                    <td><span class="status-dot <?php echo ($s['status']=='online')?'dot-online':'dot-offline'; ?>"></span> <?php echo strtoupper($s['status']); ?></td>
                    <td class="text-end pe-4">
                        <a href="process.php?action=del_service&id=<?php echo $s['id']; ?>" class="text-danger" onclick="return confirm('Delete service?')"><i data-lucide="trash-2"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table></div>
    </main>
</div></div>
<div class="modal fade" id="addS" tabindex="-1"><div class="modal-dialog"><form action="process.php?action=add_service" method="POST" class="modal-content"><div class="modal-body p-4">
    <h5 class="fw-bold mb-3">Add Service</h5>
    <input type="text" name="name" class="form-control mb-3" placeholder="Service Name" required>
    <select name="type" class="form-control mb-3"><option value="website">Website</option><option value="ip">IP/Server</option></select>
    <input type="text" name="target" class="form-control mb-3" placeholder="Target (e.g. test.nl)" required>
    <button class="btn btn-primary w-100">Save</button>
</div></form></div></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>lucide.createIcons();</script>
</body></html>