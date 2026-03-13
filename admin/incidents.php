<?php 
session_start(); 
include('../db.php'); 
if(!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Incidents | Status Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<div class="container-fluid"><div class="row">
    <?php include('navbar.php'); ?>
    <main class="col-md-10 p-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Incidents</h2>
            <button class="btn btn-primary fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addI">
                <i data-lucide="alert-triangle" class="me-1"></i> Report Incident
            </button>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <table class="table mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Status</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $res = mysqli_query($conn, "SELECT * FROM incidents ORDER BY id DESC");
                    if(mysqli_num_rows($res) == 0): ?>
                        <tr><td colspan="4" class="text-center p-5 text-muted">No active incidents reported. All systems operational.</td></tr>
                    <?php endif;
                    while($i = mysqli_fetch_assoc($res)): ?>
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-soft-danger text-danger" style="background: #fee2e2;">Active</span>
                        </td>
                        <td class="fw-bold text-dark"><?php echo htmlspecialchars($i['title']); ?></td>
                        <td class="text-muted small"><?php echo htmlspecialchars($i['description']); ?></td>
                        <td class="text-end pe-4">
                            <a href="process.php?action=del_incident&id=<?php echo $i['id']; ?>" 
                               class="btn btn-sm btn-outline-success fw-bold" 
                               onclick="return confirm('Mark this incident as resolved?')">
                                Resolve
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</div></div>

<div class="modal fade" id="addI" tabindex="-1">
    <div class="modal-dialog">
        <form action="process.php?action=add_incident" method="POST" class="modal-content border-0 shadow-lg">
            <div class="modal-body p-4">
                <h5 class="fw-bold mb-4">Report New Incident</h5>
                <div class="mb-3">
                    <label class="small fw-bold mb-1">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Database Connectivity Issues" required>
                </div>
                <div class="mb-4">
                    <label class="small fw-bold mb-1">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Provide details about the issue..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Post Incident</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>lucide.createIcons();</script>
</body>
</html>