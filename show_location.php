<?php
include 'db.php';
session_start();

// Pastikan admin login
if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Pastikan ada ID
if(!isset($_GET['id'])) {
    header("Location: show_locations.php");
    exit;
}

$id = intval($_GET['id']);
$res = $conn->query("SELECT * FROM locations WHERE id=$id");

if($res->num_rows == 0) {
    echo "Location not found!";
    exit;
}

$loc = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Show Location - SafeCampus Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
body {
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg, #E0BBE4, #FBCFE8, #CDE7FF);
    min-height: 100vh;
    margin: 0;
    display: flex;
}

.main-content { flex-grow:1; padding:40px; }

.card-container {
    max-width:700px;
    margin:auto;
    background: rgba(255,255,255,0.95);
    padding:30px;
    border-radius:16px;
    box-shadow:0 4px 20px rgba(0,0,0,0.1);
}

h3 { text-align:center; color:#4B0082; margin-bottom:25px; }

.detail-row { display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid #ddd; }
label { font-weight:600; color:#6B21A8; }
span { color:#1a1a1a; }

.button-group {
    display:flex;
    justify-content:center;
    gap:15px;
    margin-top:25px;
}

.button-group a {
    padding:10px 20px;
    border-radius:8px;
    font-weight:500;
    text-decoration:none;
    display:inline-block;
    color:#fff;
}

.button-back {
    background:#F472B6; /* pink */
}
.button-back:hover { background:#DB2777; }

.button-edit {
    background:#7C3AED; /* purple */
}
.button-edit:hover { background:#6B21A8; }

@media (max-width:768px){
    .main-content { padding:20px; }
}
</style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <div class="card-container">
        <h3>Location Details</h3>

        <div class="detail-row"><label>Name:</label><span><?= htmlspecialchars($loc['name']) ?></span></div>
        <div class="detail-row"><label>Type:</label><span><?= htmlspecialchars($loc['type']) ?></span></div>
        <div class="detail-row"><label>Latitude:</label><span><?= htmlspecialchars($loc['latitude']) ?></span></div>
        <div class="detail-row"><label>Longitude:</label><span><?= htmlspecialchars($loc['longitude']) ?></span></div>
        <div class="detail-row"><label>Created At:</label><span><?= htmlspecialchars($loc['created_at']) ?></span></div>
        <div class="detail-row"><label>Updated At:</label><span><?= htmlspecialchars($loc['updated_at']) ?></span></div>

        <div class="button-group">
            <a href="manage_location.php" class="button-back">Back</a>
            <a href="edit_location.php?id=<?= $loc['id'] ?>" class="button-edit">Edit</a>
        </div>
    </div>
</div>

</body>
</html>
