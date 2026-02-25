<?php 
include('db.php'); 
$offline_query = mysqli_query($conn, "SELECT id FROM services WHERE status = 'offline'");
$is_fully_operational = (mysqli_num_rows($offline_query) == 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">System Status</h1>
        <?php if($is_fully_operational): ?>
            <div class="badge bg-success-subtle text-success p-3 rounded-pill">
                <i data-lucide="check-circle" class="me-1"></i> All Systems Operational
            </div>
        <?php else: ?>
            <div class="badge bg-danger-subtle text-danger p-3 rounded-pill">
                <i data-lucide="alert-triangle" class="me-1"></i> Some Systems Experiencing Issues
            </div>
        <?php endif; ?>
    </div>

    <div class="card mb-5 border-0 shadow-sm">
        <div class="list-group list-group-flush">
            <?php
            $services = mysqli_query($conn, "SELECT * FROM services ORDER BY name ASC");
            while($s = mysqli_fetch_assoc($services)):
                $is_online = ($s['status'] == 'online');
            ?>
                <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <div>
                        <span class="fw-semibold"><?php echo htmlspecialchars($s['name']); ?></span>
                        <div class="small text-muted"><?php echo htmlspecialchars($s['target']); ?></div>
                    </div>
                    <span class="fw-bold <?php echo $is_online ? 'text-success' : 'text-danger'; ?>">
                        <span class="status-dot <?php echo $is_online ? 'dot-online' : 'dot-offline'; ?>"></span>
                        <?php echo strtoupper($s['status']); ?>
                    </span>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <h4 class="mb-3"><i data-lucide="megaphone" class="me-2"></i>Recent Incidents</h4>
            <?php
            $incidents = mysqli_query($conn, "SELECT * FROM incidents ORDER BY created_at DESC LIMIT 3");
            if(mysqli_num_rows($incidents) > 0):
                while($i = mysqli_fetch_assoc($incidents)): ?>
                <div class="card mb-3 border-start border-danger border-4">
                    <div class="card-body">
                        <h6 class="text-danger fw-bold"><?php echo htmlspecialchars($i['title']); ?></h6>
                        <p class="small text-muted mb-1"><?php echo nl2br(htmlspecialchars($i['description'])); ?></p>
                        <small class="text-secondary"><?php echo $i['created_at']; ?></small>
                    </div>
                </div>
            <?php endwhile; else: echo "<p class='text-muted'>No incidents reported.</p>"; endif; ?>
        </div>

        <div class="col-md-6">
            <h4 class="mb-3"><i data-lucide="calendar" class="me-2"></i>Maintenance</h4>
            <?php
            $maint = mysqli_query($conn, "SELECT * FROM maintenance ORDER BY scheduled_date ASC");
            if(mysqli_num_rows($maint) > 0):
                while($m = mysqli_fetch_assoc($maint)): ?>
                <div class="card mb-3 border-start border-primary border-4">
                    <div class="card-body">
                        <h6 class="text-primary fw-bold"><?php echo htmlspecialchars($m['title']); ?></h6>
                        <small class="d-block text-muted mb-1"><?php echo date('d M Y - H:i', strtotime($m['scheduled_date'])); ?></small>
                        <p class="small mb-0"><?php echo htmlspecialchars($m['description']); ?></p>
                    </div>
                </div>
            <?php endwhile; else: echo "<p class='text-muted'>No upcoming maintenance.</p>"; endif; ?>
        </div>
    </div>
</div>
<script>lucide.createIcons();</script>
</body>
</html>