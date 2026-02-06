<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: view_users.php");
    exit;
}

$id = intval($_GET['id']);
$res = $conn->query("SELECT * FROM registration WHERE id = $id");
$user = $res->fetch_assoc();

// Tukar timezone ke Malaysia
date_default_timezone_set('Asia/Kuala_Lumpur');

// Format created_at & updated_at
$created_at = isset($user['created_at']) ? date("d M Y, h:i A", strtotime($user['created_at'])) : 'N/A';
$updated_at = isset($user['updated_at']) ? date("d M Y, h:i A", strtotime($user['updated_at'])) : 'N/A';

if (isset($_POST['submit'])) {

    $name       = $_POST['name'];
    $username   = $_POST['username'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $birthdate  = $_POST['birthdate'];
    $gender     = $_POST['gender'];

    $conn->query("UPDATE registration SET 
        name='$name',
        username='$username',
        email='$email',
        phone='$phone',
        birthdate='$birthdate',
        gender='$gender',
        updated_at=NOW()
        WHERE id=$id
    ");

    header("Location: view_users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #E0BBE4, #FBCFE8, #CDE7FF);
        min-height: 100vh;
        margin: 0;
    }

    .d-flex {
        display: flex;
        min-height: 100vh;
        align-items: flex-start;
    }

    /* Main content area */
    .main-content {
        flex-grow: 1;
        padding: 40px 20px;
        display: flex;
        justify-content: center; /* center the card */
        align-items: flex-start;
    }

    h3 {
        text-align: center;
        margin-bottom: 30px;
        color: #4B0082;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Card styling */
    .user-card {
        background: #fff;
        padding: 35px 30px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 600px;
        transition: transform 0.3s ease;
    }
    .user-card:hover {
        transform: translateY(-5px);
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 15px;
        font-size: 15px;
        border: 1px solid #d1d5db;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #A78BFA;
        box-shadow: 0 0 0 3px rgba(167,139,250,0.2);
        outline: none;
    }

    .form-label {
        font-weight: 600;
        color: #1E3A8A;
    }

    .btn-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 25px;
    }

    .btn-primary {
        background: linear-gradient(90deg, #60A5FA, #3B82F6);
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 500;
        color: #fff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59,130,246,0.4);
    }

    .btn-secondary {
        background: linear-gradient(90deg, #A78BFA, #7C3AED);
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 500;
        color: #fff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(124,58,237,0.4);
    }

    /* timestamps below gender */
    .timestamps {
        text-align: center;
        margin-top: 15px;
        font-size: 14px;
        color: #6B7280;
        background: #F3F4F6;
        padding: 10px;
        border-radius: 12px;
    }

    /* Responsive adjustments */
    @media(max-width: 768px){
        .main-content {
            padding: 20px 15px;
        }
        .user-card {
            padding: 25px 20px;
        }
    }
</style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="user-card">
            <h3>Edit User</h3>
            <form method="POST" action="edit_user.php?id=<?= $id ?>">

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Birthdate</label>
                    <input type="date" name="birthdate" class="form-control" value="<?= htmlspecialchars($user['birthdate']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select" required>
                        <option value="Male" <?= $user['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $user['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>

                

                <div class="btn-container">
                    <a href="view_users.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" name="submit" class="btn btn-primary">Update User</button>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>
