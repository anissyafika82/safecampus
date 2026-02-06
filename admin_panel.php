<?php
session_start();
include 'db.php';

// ✅ Session check first
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

// Ambil username admin dari session
$adminUsername = $_SESSION['admin'];

// Include sidebar safely
include 'sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Panel</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #CDE7FF, #E0BBE4, #FBCFE8);
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    margin: 0;
}

/* MAIN CONTENT */
.main-content {
    margin-left: 220px; /* sama dengan sidebar width */
    padding: 60px 40px;
}

/* PANEL CARD */
.panel-card {
    background: #fff;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    transition: 0.3s;
    text-align: center;
}

.panel-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.panel-card h5 {
    margin-top: 15px;
    font-weight: 600;
    color: #4B0082;
}

.panel-card p {
    color: #6B7280;
    font-size: 14px;
}

/* ICON STYLE */
.panel-icon {
    font-size: 40px;
}

/* COPYRIGHT */
.footer {
    text-align: center;
    margin-top: 60px;
    color: #6B7280;
    font-size: 13px;
}
</style>
</head>

<body>

<div class="main-content">

    <h2 class="text-center fw-bold mb-3 text-dark">
        Admin Panel
    </h2>

    <p class="text-center text-muted mb-5">
        Welcome, manage your admin account securely
    </p>

    <div class="row g-4 justify-content-center">

        <!-- EDIT PROFILE -->
        <div class="col-md-4">
            <a href="edit_admin_profile.php" class="text-decoration-none">
                <div class="panel-card">
                    <div class="panel-icon">👤</div>
                    <h5>Edit Profile</h5>
                    <p>Update your username and profile details</p>
                </div>
            </a>
        </div>

        <!-- RESET PASSWORD -->
        <div class="col-md-4">
            <a href="show_forgot_password.php" class="text-decoration-none">
                <div class="panel-card">
                    <div class="panel-icon">🔑</div>
                    <h5>Reset Password</h5>
                    <p>Change or reset your admin password</p>
                </div>
            </a>
        </div>

        <!-- DELETE ACCOUNT -->
        <div class="col-md-4">
            <a href="admin_delete_account.php" class="text-decoration-none">
                <div class="panel-card border border-danger">
                    <div class="panel-icon text-danger">🗑️</div>
                    <h5 class="text-danger">Delete Account</h5>
                    <p class="text-danger">Permanently remove your admin account</p>
                </div>
            </a>
        </div>

    </div>

    <div class="footer">
        &copy; <?= date('Y') ?> SafeCampus. All Rights Reserved.
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
