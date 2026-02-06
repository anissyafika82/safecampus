<div class="sidebar bg-dark text-white d-flex flex-column">
    
    <!-- LOGO / TITLE -->
    <div class="sidebar-header text-center py-4">
        <h4 class="fw-bold mb-0">SafeCampus</h4>
        <small class="text-secondary">Admin System</small>
    </div>

    <!-- MENU -->
    <ul class="nav nav-pills flex-column gap-1 px-3 flex-grow-1">

        <li class="nav-item">
            <a href="dashboard.php" class="nav-link text-white">
                🏠 Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="view_users.php" class="nav-link text-white">
                👥 Users
            </a>
        </li>

        <li class="nav-item">
            <a href="admin.php#reports" class="nav-link text-white">
                🚨 Reports
            </a>
        </li>

        <li class="nav-item">
            <a href="manage_location.php" class="nav-link text-white">
                📍 Locations
            </a>
        </li>

        <li class="nav-item">
            <a href="admin_panel.php" class="nav-link text-white">
                🛠️ Admin Panel
            </a>
        </li>

        <li class="nav-item">
            <a href="about.php" class="nav-link text-white">
                ℹ️ About
            </a>
        </li>

    </ul>

    <!-- LOGOUT -->
    <div class="px-3 pb-3">
        <a href="logout.php" class="nav-link text-danger fw-semibold">
            🚪 Logout
        </a>
    </div>

    <!-- COPYRIGHT -->
    <div class="text-center text-secondary small py-2 border-top border-secondary">
        © <?php echo date("Y"); ?> SafeCampus
    </div>

</div>

<style>
/* ===== SIDEBAR BASE ===== */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 220px;
    height: 100vh;
    background-color: #111827;
    z-index: 1000;
}

/* ===== HEADER ===== */
.sidebar-header {
    border-bottom: 1px solid #1f2937;
}

/* ===== NAV LINKS CONSISTENT ===== */
.sidebar .nav-link {
    display: flex;
    align-items: center;
    height: 44px;                /* 🔑 CONSISTENT HEIGHT */
    padding: 0 14px;
    border-radius: 8px;
    font-weight: 500;
    transition: background 0.2s ease, color 0.2s ease;
}

/* HOVER */
.sidebar .nav-link:hover {
    background-color: #1f2937;
}

/* ACTIVE (OPTIONAL – kalau guna nanti) */
.sidebar .nav-link.active {
    background-color: #1db592;
    color: #ffffff !important;
}

/* ===== MAIN CONTENT OFFSET ===== */
.main-content {
    margin-left: 220px;
    padding: 40px;
}
</style>
