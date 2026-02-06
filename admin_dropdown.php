<?php
// admin_dropdown.php
// Ensure session is started
if(!isset($_SESSION)) session_start();

// Get admin username
$adminUsername = isset($_SESSION['admin']) ? $_SESSION['admin'] : 'Admin';
?>

<div class="admin-dropdown dropdown">
         <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" 
                style="background-color: #1db592; color: #fff; font-weight: 600;">
            <?= htmlspecialchars($adminUsername) ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="edit_admin_profile.php">Edit Profile</a></li>
            <li><a class="dropdown-item" href="show_forgot_password.php">Forgot Password</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="admin_delete_account.php">Delete Account</a></li>
        </ul>
    </div>
