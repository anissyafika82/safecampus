<?php
include 'db.php';
session_start();

/* Set timezone Malaysia */
date_default_timezone_set('Asia/Kuala_Lumpur');

if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: admin.php");
    exit;
}

$id = intval($_GET['id']);
$res = $conn->query("SELECT * FROM reports WHERE id=$id");

if($res->num_rows == 0){
    echo "Report not found!";
    exit;
}

$r = $res->fetch_assoc();

/* Current Malaysia datetime */
$currentMYTime = date('Y-m-d H:i:s');

if(isset($_POST['submit'])){
    $incident_type = $_POST['incident_type'];
    $description   = $_POST['description'];
    $location      = $_POST['location'];
    $latitude      = $_POST['latitude'];
    $longitude     = $_POST['longitude'];
    $status        = $_POST['status'];

    /* Update guna waktu Malaysia */
    $conn->query("UPDATE reports SET 
        incident_type='$incident_type',
        description='$description',
        location='$location',
        latitude='$latitude',
        longitude='$longitude',
        status='$status',
        updated_at='$currentMYTime'
        WHERE id=$id");

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Report</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E0BBE4, #FBCFE8, #CDE7FF);
    min-height: 100vh;
    margin: 0;
}
.d-flex { display: flex; }
.main-content { flex-grow: 1; padding: 40px; }

.container {
    max-width: 700px;
    background: #fff;
    padding: 30px 40px;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0,0,0,.15);
    transition: 0.3s;
}
.container:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,.2);
}

h3 {
    text-align: center;
    margin-bottom: 30px;
    color: #4B0082;
    font-weight: 600;
}

label {
    font-weight: 500;
    color: #4B0082;
}

input.form-control,
textarea.form-control,
select.form-control {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 10px;
}

textarea.form-control { min-height: 100px; }

.btn-container {
    display: flex;
    justify-content: flex-start;
    gap: 15px;
    margin-top: 20px;
}

.btn-edit, .btn-back, button.btn-primary {
    padding: 10px 25px;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    color: #fff;
    border: none;
}

.btn-edit { background: #A78BFA; }
.btn-edit:hover { background: #7C3AED; }

.btn-back { background: #F472B6; }
.btn-back:hover { background: #DB2777; }

button.btn-primary { background: #4B0082; }
button.btn-primary:hover { background: #2E0267; }
</style>
</head>
<body>

<div class="d-flex">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container">
            <h3>Edit Report</h3>

            <!-- Waktu Malaysia (info sahaja) -->
           

            <form method="POST">

                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($r['username']) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label>Incident Type</label>
                    <input type="text" name="incident_type" class="form-control" value="<?= htmlspecialchars($r['incident_type']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" required><?= htmlspecialchars($r['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($r['location']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Latitude</label>
                    <input type="text" name="latitude" class="form-control" value="<?= htmlspecialchars($r['latitude']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Longitude</label>
                    <input type="text" name="longitude" class="form-control" value="<?= htmlspecialchars($r['longitude']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Unresolved" <?= $r['status']=='Unresolved'?'selected':'' ?>>Unresolved</option>
                        <option value="Pending" <?= $r['status']=='Pending'?'selected':'' ?>>Pending</option>
                        <option value="In Progress" <?= $r['status']=='In Progress'?'selected':'' ?>>In Progress</option>
                        <option value="Resolved" <?= $r['status']=='Resolved'?'selected':'' ?>>Resolved</option>
                    </select>
                </div>

                <div class="btn-container">
                    <a href="admin.php" class="btn-back">Cancel</a>
                    <button type="submit" name="submit" class="btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>
