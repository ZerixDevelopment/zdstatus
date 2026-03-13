<?php 
session_start(); 
include('../db.php'); 

// Check if admin is logged in
if(!isset($_SESSION['admin'])) { 
    header('Location: login.php'); 
    exit(); 
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Administrators | Status Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include('navbar.php'); ?>

        <main class="col-md-10 p-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark">Administrators</h2>
                <button class="btn btn-primary shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addUser">
                    <i data-lucide="user-plus" class="me-1"></i> Add Administrator
                </button>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden">
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Username</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $res = mysqli_query($conn, "SELECT * FROM users ORDER BY gebruikersnaam ASC");
                        while($u = mysqli_fetch_assoc($res)): 
                        ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i data-lucide="user" style="width: 18px; color: #64748b;"></i>
                                    </div>
                                    <span class="fw-bold text-dark"><?php echo htmlspecialchars($u['gebruikersnaam']); ?></span>
                                    <?php if($u['gebruikersnaam'] == $_SESSION['admin']): ?>
                                        <span class="badge bg-soft-primary text-primary ms-2" style="background: #e0e7ff; font-size: 0.7rem;">YOU</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <?php if($u['gebruikersnaam'] != $_SESSION['admin']): ?>
                                    <a href="process.php?action=del_user&id=<?php echo $u['id']; ?>" 
                                       class="btn btn-sm text-danger border-0" 
                                       onclick="return confirm('Are you sure you want to remove this administrator?')">
                                        <i data-lucide="user-minus" style="width: 18px;"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small italic">Active Session</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="addUser" tabindex="-1">
    <div class="modal-dialog">
        <form action="process.php?action=add_user" method="POST" class="modal-content border-0 shadow-lg">
            <div class="modal-body p-4">
                <h5 class="fw-bold mb-4">Add New Administrator</h5>
                
                <div class="mb-3">
                    <label class="small fw-bold mb-1">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i data-lucide="user" style="width: 16px;"></i></span>
                        <input type="text" name="username" class="form-control border-start-0" placeholder="Enter username" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="small fw-bold mb-1">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i data-lucide="lock" style="width: 16px;"></i></span>
                        <input type="password" name="password" class="form-control border-start-0" placeholder="Enter secure password" required>
                    </div>
                    <div class="form-text mt-2 small text-muted">Passwords are automatically encrypted (hashed).</div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold">Create Account</button>
                <button type="button" class="btn btn-link w-100 text-muted small mt-2" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>lucide.createIcons();</script>
</body>
</html>