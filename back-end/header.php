<?php
session_start();
// Pastikan session 'admin' wujud, kalau tak set default
$adminName = $_SESSION['admin'] ?? 'admin';
?>

<!-- HEADER -->
<div class="d-flex justify-content-end align-items-center p-3 shadow-sm" style="background-color: #f8f9fa;">
    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
            <?= htmlspecialchars($adminName); ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu" style="min-width: 150px;">
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>

<!-- Bootstrap JS & Popper -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
/* Dropdown button sama background dengan header */
.dropdown-toggle {
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    color: #000;
    font-weight: 500;
}

.dropdown-toggle:focus {
    box-shadow: none;
}

.dropdown-menu {
    border-radius: 10px;
    padding: 0;
}

.dropdown-item {
    font-weight: 500;
}

/* Hover effect */
.dropdown-item:hover {
    background-color: #e9ecef;
}
</style>
