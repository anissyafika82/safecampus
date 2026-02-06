<?php
session_start();
include 'db.php';

// Ensure admin is logged in
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

// Include sidebar
include 'sidebar.php';

// Get admin username from session
$adminUsername = $_SESSION['admin'];

// Fetch current admin data from database
$stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
$stmt->bind_param("s", $adminUsername);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Handle form submission (POST)
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $newUsername = trim($_POST['username']);
    $newPassword = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']); // confirm password

    if(empty($newUsername)){
        $error = "Username cannot be empty!";
    } else {
        // Validate confirm password if new password is entered
        if(!empty($newPassword) && $newPassword !== $confirmPassword){
            $error = "New Password and Confirm Password do not match!";
        } else {
            if(!empty($newPassword)){
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateStmt = $conn->prepare("UPDATE admin SET username=?, password=? WHERE username=?");
                $updateStmt->bind_param("sss", $newUsername, $hashedPassword, $adminUsername);
            } else {
                $updateStmt = $conn->prepare("UPDATE admin SET username=? WHERE username=?");
                $updateStmt->bind_param("ss", $newUsername, $adminUsername);
            }

            if($updateStmt->execute()){
                $_SESSION['admin'] = $newUsername; // update session
                $success = "Profile updated successfully!";
                $adminUsername = $newUsername;
            } else {
                $error = "Failed to update profile!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Admin Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(135deg, #CDE7FF, #E0BBE4, #FBCFE8);
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    margin: 0;
}

/* Adjust main content with sidebar */
.main-content {
    margin-left: 220px; /* same as sidebar width */
    padding: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.profile-card {
    background: #fff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 450px;
}

.profile-card h3 {
    text-align: center;
    margin-bottom: 25px;
    color: #4B0082;
    font-weight: 600;
}

.form-label {
    font-weight: 500;
    color: #4B0082;
}

.btn-save {
    background: #60A5FA;
    color: #fff;
    font-weight: 500;
    border-radius: 12px;
    transition: 0.3s;
}

.btn-save:hover {
    background: #3B82F6;
}

.btn-cancel {
    background: #A78BFA;
    color: #fff;
    font-weight: 500;
    border-radius: 12px;
    transition: 0.3s;
}

.btn-cancel:hover {
    background: #7C3AED;
}

.alert {
    border-radius: 12px;
}
</style>
</head>
<body>

<div class="main-content">
    <div class="profile-card">
        <h3>Edit Profile</h3>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="full name">
            </div>
    
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="username">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="email">
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="admin_panel.php" class="btn btn-cancel">Cancel</a>
                <button type="submit" class="btn btn-save">Update</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
