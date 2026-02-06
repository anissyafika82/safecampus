<?php
include 'db.php';
include 'sidebar.php'; // <-- Add this line to include the sidebar
session_start();

// If admin submits form
if(isset($_POST['reset'])) {
    $username = trim($_POST['username']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE admin SET password=? WHERE username=?");
        $stmt->bind_param("ss", $hashed_password, $username);
        if($stmt->execute()){
            if($stmt->affected_rows > 0){
                $success = "Password updated successfully.";
            } else {
                $error = "Username not found!";
            }
        } else {
            $error = "Error: " . $conn->error;
        }
        $stmt->close();
    }
}

// Pre-fill username if admin is logged in
$prefillUsername = isset($_SESSION['admin']) ? $_SESSION['admin'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(135deg, #CDE7FF, #E0BBE4, #FBCFE8);
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    margin: 0;
    display: flex;
}

/* Sidebar */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 220px;
    height: 100vh;
    overflow-y: auto;
}

/* Main content */
.main-content {
    margin-left: 220px; /* same as sidebar width */
    flex-grow: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
}

/* Forgot password card */
.card {
    background: #fff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 450px;
}

.card h3 {
    text-align: center;
    margin-bottom: 25px;
    color: #4B0082;
    font-weight: 600;
}

.form-label {
    font-weight: 500;
    color: #4B0082;
}

input.form-control {
    border-radius: 12px;
    padding: 12px 14px;
    margin-bottom: 15px;
}

.btn-reset {
    background: #60A5FA;
    color: #fff;
    font-weight: 500;
    border-radius: 12px;
    transition: 0.3s;
}

.btn-reset:hover {
    background: #3B82F6;
}

.btn-cancel {
    background: #A78BFA;
    color: #fff;
    font-weight: 500;
    border-radius: 12px;
    transition: 0.3s;
    text-decoration: none;
    text-align: center;
    display: inline-block;
    padding: 10px 25px;
}

.btn-cancel:hover {
    background: #7C3AED;
    color: #fff;
}

.alert {
    border-radius: 12px;
    margin-bottom: 15px;
}
</style>
</head>
<body>

<div class="main-content">
    <div class="card">
        <h3>Reset Password</h3>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">
            <label class="form-label">Cuurent Password</label>
            <input type="text" name="password" class="form-control" placeholder="Password" required>

            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" placeholder="New Password" required>

            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>

            <div class="d-flex justify-content-between mt-3">
                <a href="admin_panel.php" class="btn-cancel">Cancel</a>
                <button type="submit" name="reset" class="btn btn-reset">Update</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
