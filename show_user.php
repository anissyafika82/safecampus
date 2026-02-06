<?php
include 'db.php';
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Pastikan ada id
if(!isset($_GET['id'])){
    header("Location: user.php");
    exit;
}

$id = intval($_GET['id']);
$res = $conn->query("SELECT * FROM registration WHERE id=$id");
$user = $res->fetch_assoc();

if(!$user){
    echo "<script>alert('User not found'); window.location='user.php';</script>";
    exit;
}

// Tukar timezone ke Malaysia
date_default_timezone_set('Asia/Kuala_Lumpur');

// Format created_at dan updated_at
$created_at = date("d M Y, h:i A", strtotime($user['created_at']));
$updated_at = date("d M Y, h:i A", strtotime($user['updated_at']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Show User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #E0BBE4, #FBCFE8, #CDE7FF);
        min-height: 100vh;
        margin: 0;
    }

    .main-content {
        flex-grow:1;
        padding: 40px;
    }

    h3 {
        text-align: center;
        margin-bottom: 20px;
        color: #4B0082;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .user-card {
        max-width: 600px;
        margin: auto;
        background: #fff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .user-card h4 {
        margin-bottom: 20px;
        color: #4B0082;
        font-weight: 600;
        text-align: center;
    }

    .user-detail {
        margin-bottom: 15px;
        font-size: 16px;
    }

    .user-detail span {
        font-weight: 600;
        color: #1E3A8A;
    }

    .btn-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }

    .btn-back, .btn-edit-user {
        padding: 10px 25px;
        border-radius: 12px;
        font-weight: 500;
        text-decoration: none;
        text-align: center;
        transition: 0.3s;
    }

    .btn-back {
        background: #A78BFA;
        color: #fff;
    }
    .btn-back:hover { background: #7C3AED; }

    .btn-edit-user {
        background: #60A5FA;
        color: #fff;
    }
    .btn-edit-user:hover { background: #3B82F6; }
</style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <h3>User Details</h3>
        <div class="user-card">
            <div class="user-detail"><span>Name:</span> <?= htmlspecialchars($user['name']) ?></div>
            <div class="user-detail"><span>Username:</span> <?= htmlspecialchars($user['username']) ?></div>
            <div class="user-detail"><span>Email:</span> <?= htmlspecialchars($user['email']) ?></div>
            <div class="user-detail"><span>Phone:</span> <?= htmlspecialchars($user['phone']) ?></div>
            <div class="user-detail"><span>Birthdate:</span> <?= htmlspecialchars($user['birthdate']) ?></div>
            <div class="user-detail"><span>Gender:</span> <?= htmlspecialchars($user['gender']) ?></div>
            <div class="user-detail"><span>Created At:</span> <?= $created_at ?></div>
            <div class="user-detail"><span>Updated At:</span> <?= $updated_at ?></div>

            <div class="btn-container">
                <a href="view_users.php" class="btn-back">Cancel</a>
                <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn-edit-user">Edit User</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
