<?php
include 'db.php';
session_start();

if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// DELETE LOCATION
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM locations WHERE id=$id");
}

// FETCH LOCATIONS
$result = $conn->query("
    SELECT id, name, type, latitude, longitude, created_at
    FROM locations
    ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Locations Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg, #E0BBE4, #FBCFE8, #CDE7FF);
    min-height:100vh;
    margin:0;
}

.main-content{
    flex-grow:1;
    padding:40px;
}

h3{
    text-align:center;
    margin-bottom:25px;
    color:#4B0082;
    font-weight:600;
}

.table-responsive{
    background:rgba(255,255,255,0.95);
    border-radius:16px;
    padding:20px;
    box-shadow:0 4px 20px rgba(0,0,0,0.1);
}

table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 8px;
}

th{
    background:#A78BFA;
    color:white;
    text-align:center;
    padding:12px;
    font-weight:600;
    border-radius:12px 12px 0 0;
}

td{
    text-align:center;
    padding:12px;
    background:#F3F4F6;
    border-radius:8px;
}

tr:hover td{
    background:#EDE9FE;
    transition:0.3s;
}

.btn-delete{
    background:#F472B6;
    color:white;
    border-radius:8px;
    padding:6px 14px;
    text-decoration:none;
    font-weight:500;
}
.btn-delete:hover{
    background:#DB2777;
}
</style>
</head>



<body>

<div class="d-flex">

<!-- SIDEBAR -->
<?php include 'sidebar.php'; ?>

<!-- MAIN -->
<div class="main-content">

<h3>Locations Data</h3>

<div class="table-responsive">
<table>

<thead>
<tr>
    <th>Type</th>
    <th>Location</th>
    <th>Latitude</th>
    <th>Longitude</th>
    <th>Time</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['type'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['latitude'] ?></td>
    <td><?= $row['longitude'] ?></td>
    <td><?= $row['created_at'] ?></td>
    <td>
        <a href="?delete=<?= $row['id'] ?>" 
           class="btn-delete"
           onclick="return confirm('Delete this location?')">
           Delete
        </a>
    </td>
</tr>
<?php endwhile; ?>

</tbody>

</table>
</div>

</div>
</div>

</body>
</html>
