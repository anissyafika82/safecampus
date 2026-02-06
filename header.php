<?php
// header.php
if(!isset($_SESSION)) session_start(); // pastikan session start
$adminUsername = isset($_SESSION['admin']) ? $_SESSION['admin'] : 'Admin';
?>

<!-- Admin dropdown -->
<div class="admin-dropdown dropdown" style="position:absolute; top:20px; right:40px;">
    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" 
            style="background-color: #EC4899; color:#fff; font-weight:600;">
        <?= htmlspecialchars($adminUsername) ?>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="edit_admin_profile.php">Edit Profile</a></li>
        <li><a class="dropdown-item" href="show_forgot_password.php">Forgot Password</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="admin_delete_account.php" 
               onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="admin_logout.php">Logout</a></li>
    </ul>
</div>
