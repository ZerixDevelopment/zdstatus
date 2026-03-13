<nav class="col-md-2 admin-sidebar">
    <a href="index.php" class="sidebar-brand px-3 text-decoration-none fw-bold">STATUS ADMIN</a>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" href="index.php">
                <i data-lucide="layout-dashboard"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'services.php') ? 'active' : ''; ?>" href="services.php">
                <i data-lucide="server"></i> Services
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'incidents.php') ? 'active' : ''; ?>" href="incidents.php">
                <i data-lucide="alert-circle"></i> Incidents
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'maintenance.php') ? 'active' : ''; ?>" href="maintenance.php">
                <i data-lucide="calendar"></i> Maintenance
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'active' : ''; ?>" href="users.php">
                <i data-lucide="users"></i> Users
            </a>
        </li>
        <hr class="mx-3 my-4" style="opacity: 0.1;">
        <li class="nav-item">
            <a class="nav-link text-danger" href="logout.php">
                <i data-lucide="log-out"></i> Logout
            </a>
        </li>
    </ul>
</nav>