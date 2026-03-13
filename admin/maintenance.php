<?php session_start(); include('../db.php'); if(!isset($_SESSION['admin'])) header('Location: login.php'); ?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<div class="container-fluid"><div class="row">
    <?php include('navbar.php'); ?>
    <main class="col-md-10 p-5">
        <div class="d-flex justify-content-between mb-4"><h2 class="fw-bold">Maintenance</h2><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addM">Inplannen</button></div>
        <div class="card p-0 border-0 shadow-sm"><table class="table mb-0">
            <thead><tr><th class="ps-4">Titel</th><th>Datum</th><th class="text-end pe-4">Actie</th></tr></thead>
            <tbody>
                <?php $res = mysqli_query($conn, "SELECT * FROM maintenance ORDER BY scheduled_date ASC"); while($m = mysqli_fetch_assoc($res)): ?>
                <tr><td class="ps-4 fw-bold"><?php echo $m['title']; ?></td><td><?php echo $m['scheduled_date']; ?></td><td class="text-end pe-4"><a href="process.php?action=del_maint&id=<?php echo $m['id']; ?>" class="text-danger"><i data-lucide="trash-2"></i></a></td></tr>
                <?php endwhile; ?>
            </tbody>
        </table></div>
    </main>
</div></div>
<div class="modal fade" id="addM" tabindex="-1"><div class="modal-dialog"><form action="process.php?action=add_maint" method="POST" class="modal-content"><div class="modal-body p-4"><h5 class="fw-bold mb-3">Schedule Work</h5><input type="text" name="title" class="form-control mb-3" placeholder="Titel" required><input type="datetime-local" name="date" class="form-control mb-3" required><textarea name="description" class="form-control mb-3" placeholder="Uitleg"></textarea><button class="btn btn-primary w-100">Opslaan</button></div></form></div></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>lucide.createIcons();</script>
</body></html>