<?php
include 'db.php';
session_start();

if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: view_reports.php");
    exit;
}

$id = intval($_GET['id']);
$res = $conn->query("SELECT * FROM reports WHERE id=$id");

if($res->num_rows == 0){
    echo "Report not found!";
    exit;
}

$r = $res->fetch_assoc();

/* Set timezone Malaysia */
date_default_timezone_set('Asia/Kuala_Lumpur');

/* Format time ikut Malaysia (DISPLAY SAHAJA) */
$createdMYTime = !empty($r['timestamp'])
    ? date('d M Y, h:i A', strtotime($r['timestamp'])) . ' MYT'
    : '-';

$updatedMYTime = !empty($r['updated_at'])
    ? date('d M Y, h:i A', strtotime($r['updated_at'])) . ' MYT'
    : 'Not updated yet';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Show Report</title>
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
    margin-bottom: 30px;
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

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 15px;
    background: #F3F4F6;
    margin-bottom: 10px;
    border-radius: 8px;
}
.detail-row label {
    font-weight: 600;
    color: #4B0082;
    width: 150px;
}
.detail-row span {
    flex-grow: 1;
    color: #1a1a1a;
}

.btn-container {
    display: flex;
    justify-content: flex-start;
    gap: 15px;
    margin-top: 25px;
}
.btn-edit, .btn-back {
    padding: 10px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    color: #fff;
}
.btn-edit { background: #A78BFA; }
.btn-edit:hover { background: #7C3AED; }
.btn-back { background: #F472B6; }
.btn-back:hover { background: #DB2777; }
</style>
</head>
<body>

<div class="d-flex">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container">
            <h3>Report Details</h3>

            <div class="detail-row"><label>Username:</label><span><?= htmlspecialchars($r['username']) ?></span></div>
            <div class="detail-row"><label>Incident Type:</label><span><?= htmlspecialchars($r['incident_type']) ?></span></div>
            <div class="detail-row"><label>Description:</label><span><?= htmlspecialchars($r['description']) ?></span></div>
            <div class="detail-row"><label>Location:</label><span><?= htmlspecialchars($r['location']) ?></span></div>
            <div class="detail-row"><label>Latitude:</label><span><?= htmlspecialchars($r['latitude']) ?></span></div>
            <div class="detail-row"><label>Longitude:</label><span><?= htmlspecialchars($r['longitude']) ?></span></div>
            <div class="detail-row"><label>Status:</label><span><?= htmlspecialchars($r['status']) ?></span></div>

            <!-- TIME MALAYSIA -->
            <div class="detail-row"><label>Time:</label><span><?= $createdMYTime ?></span></div>
            <div class="detail-row"><label>Updated At:</label><span><?= $updatedMYTime ?></span></div>

            <div class="btn-container">
                <a href="admin.php" class="btn-back">Back</a>
                <a href="edit_report.php?id=<?= $r['id'] ?>" class="btn-edit">Edit</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
