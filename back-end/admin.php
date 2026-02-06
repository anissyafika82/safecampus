<?php
include 'db.php';
session_start();

if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

$user_count   = $conn->query("SELECT id FROM registration")->num_rows;
$report_count = $conn->query("SELECT id FROM reports")->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>SafeCampus Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E0BBE4, #FBCFE8, #CDE7FF);
    min-height: 100vh;
    margin: 0;
}
.main-content { flex-grow: 1; padding: 40px; }

h3 {
    text-align: center;
    margin-bottom: 30px;
    color: #4B0082;
    font-weight: 600;
}

.card {
    border-radius: 16px;
    background: rgba(255,255,255,0.95);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: .3s;
}
.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
.card h6 { color:#6B21A8; font-weight:500; }
.card h2 { color:#4B0082; font-weight:700; }

/* BUTTON CONTAINER — DIUBAH KE KIRI */
.btn-container {
    display: flex;
    justify-content: flex-start; /* ⬅️ PERUBAHAN SAHAJA */
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 25px;
}

.btn-custom {
    border-radius: 12px;
    font-weight: 600;
    padding: 10px 25px;
    text-decoration: none;
    color: #1a1a1a;
    border: 2px solid #1a1a1a;
    display: inline-block;
    transition: .3s;
}
.btn-add { 
    background: linear-gradient(90deg, #C4B5FD, #FBCFE8); 
}
.btn-add:hover { 
    transform: translateY(-2px); 
    box-shadow: 0 5px 15px rgba(196,181,253,0.4);
}

.btn-show {
    background: linear-gradient(90deg, #3B82F6, #60A5FA);
    color: #fff;
    border-radius: 8px;
    padding: 6px 14px;
    font-weight: 500;
    text-decoration: none;
    box-shadow: 0 3px 8px rgba(59,130,246,0.3);
    transition: 0.3s;
}
.btn-show:hover {
    background: linear-gradient(90deg, #2563EB, #3B82F6);
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(59,130,246,0.4);
}

.btn-edit {
    background: #A78BFA;
    color: #fff;
    border-radius: 8px;
    padding: 6px 14px;
    text-decoration: none;
    font-weight: 500;
}
.btn-edit:hover { background:#7C3AED; }

.btn-delete {
    background: #F472B6;
    color: #fff;
    border-radius: 8px;
    padding: 6px 14px;
    text-decoration: none;
    font-weight: 500;
}
.btn-delete:hover { background:#DB2777; }

.table-responsive {
    background: rgba(255,255,255,0.95);
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,.1);
}
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
}
thead th {
    background: #A78BFA;
    color: #fff;
    font-weight: 600;
    text-align: center;
    padding: 12px;
    border-radius: 12px 12px 0 0;
}
tbody td {
    text-align: center;
    padding: 12px;
    background: #F3F4F6;
    border-radius: 8px;
}
tbody tr:hover td { background: #EDE9FE; }

table tbody td a {
    display: inline-block;
    margin: 2px 5px;
}

@media (max-width:768px){
    .btn-container { flex-direction: column; }
    table { font-size:14px; }
}
</style>
</head>

<body>
<div class="d-flex">

    <?php include 'sidebar.php'; ?>

    <div class="main-content">

        <h3>Incident Reports</h3>

        <div class="row my-4">
            <div class="col-md-6 mb-3">
                <div class="card text-center p-4">
                    <h6>Total Users</h6>
                    <h2><?= $user_count ?></h2>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card text-center p-4">
                    <h6>Total Reports</h6>
                    <h2><?= $report_count ?></h2>
                </div>
            </div>
        </div>

        <div class="btn-container">
            <a href="add_report.php" class="btn-custom btn-add">Add Report</a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Status</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $res = $conn->query("SELECT * FROM reports ORDER BY timestamp DESC");
                while($r = $res->fetch_assoc()){
                    echo "<tr>
                        <td>{$r['username']}</td>
                        <td>{$r['incident_type']}</td>
                        <td>{$r['description']}</td>
                        <td>{$r['location']}</td>
                        <td>{$r['latitude']}</td>
                        <td>{$r['longitude']}</td>
                        <td>{$r['status']}</td>
                        <td>{$r['timestamp']}</td>
                        <td>
                            <a href='show_report.php?id={$r['id']}' class='btn-show'>Show</a>
                            <a href='edit_report.php?id={$r['id']}' class='btn-edit'>Edit</a>
                            <a href='delete_report.php?id={$r['id']}' 
                               class='btn-delete'
                               onclick=\"return confirm('Are you sure you want to delete this report?');\">
                               Delete
                            </a>
                        </td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
</body>
</html>
