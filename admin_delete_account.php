<?php
include 'db.php';
include 'sidebar.php'; // <-- Include sidebar
session_start();

// Ensure admin is logged in
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

$adminUsername = $_SESSION['admin'];

// Handle deletion
if(isset($_POST['delete'])){
    // Confirm deletion in PHP (after JS confirmation)
    $stmt = $conn->prepare("DELETE FROM admin WHERE username=?");
    $stmt->bind_param("s", $adminUsername);

    if($stmt->execute()){
        $stmt->close();
        session_destroy(); // logout
        header("Location: admin_login.php?deleted=1");
        exit;
    } else {
        $error = "Failed to delete account: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Delete Admin Account</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(135deg, #FECACA, #FBCFE8, #C7D2FE);
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
    margin-left: 220px;
    flex-grow: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
}

/* Card */
.card {
    background: #fff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 500px;
    text-align: center;
}

.card h3 {
    color: #B91C1C;
    margin-bottom: 20px;
    font-weight: 700;
}

.card p {
    margin-bottom: 25px;
    color: #4B0082;
    font-weight: 500;
}

.btn-cancel {
    background: #A78BFA;
    color: #fff;
    font-weight: 500;
    border-radius: 12px;
    padding: 10px 25px;
    transition: 0.3s;
    text-decoration: none;
}

.btn-cancel:hover {
    background: #7C3AED;
    color: #fff;
}

.btn-delete {
    background: #EF4444;
    color: #fff;
    font-weight: 500;
    border-radius: 12px;
    padding: 10px 25px;
    transition: 0.3s;
    border: none;
}

.btn-delete:hover {
    background: #B91C1C;
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
        <h3>Delete Account</h3>
        <p>Are you sure you want to delete your admin account? <br>This action cannot be undone!</p>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-between">
            <a href="admin_panel.php" class="btn-cancel">Cancel</a>
            <form method="POST" onsubmit="return confirmDelete();">
                <button type="submit" name="delete" class="btn-delete">Delete Account</button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(){
    return confirm("Are you sure you want to permanently delete your account?");
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
