<?php

include 'db.php';
include 'sidebar.php';

/* TOTAL LOCATION */
$locationQuery = "SELECT COUNT(*) AS total FROM locations";
$locationResult = $conn->query($locationQuery);
$location = $locationResult->fetch_assoc();

/* TOTAL REPORT TODAY (Fix ikut Malaysia Time +8) */
$todayQuery = "
SELECT COUNT(*) AS total 
FROM reports 
WHERE DATE(CONVERT_TZ(timestamp, '+00:00', '+08:00')) = CURDATE()
";
$todayResult = $conn->query($todayQuery);
$today = $todayResult->fetch_assoc();

/* TOTAL UNRESOLVED ACCIDENT */
$unresolvedQuery = "SELECT COUNT(*) AS total FROM reports WHERE status = 'unresolved'";
$unresolvedResult = $conn->query($unresolvedQuery);
$unresolved = $unresolvedResult->fetch_assoc();

/* REPORT STATUS SUMMARY (UNTUK CHART) */
$statusQuery = "
SELECT status, COUNT(*) AS total 
FROM reports 
GROUP BY status
";
$statusResult = $conn->query($statusQuery);

$statusLabels = [];
$statusData = [];

while ($row = $statusResult->fetch_assoc()) {
    $statusLabels[] = ucfirst($row['status']);
    $statusData[] = $row['total'];
}

// Tambah Pending jika belum ada
if (!in_array('Pending', $statusLabels)) {
    $statusLabels[] = 'Pending';
    $statusData[] = 0; // nilai awal 0
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    background: linear-gradient(135deg, #ff9a9e, #a18cd1, #84fab0);
    min-height:100vh;
    margin:0;
    font-family: Arial, sans-serif;
}

/* Sidebar */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 220px;
    height: 100vh;
    overflow-y: auto;
    z-index: 1000;
}

/* Content utama */
.main-content {
    margin-left: 220px;
    padding: 40px;
}

/* Cards */
.card {
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}

/* Buang underline link */
.card-link {
    text-decoration: none;
    color: inherit;
}

/* Active link highlight */
.nav-link.active {
    background-color: #495057;
    border-radius: 8px;
}

/* Chart kecil */
#statusChart {
    max-width: 300px;   /* saiz chart dikecilkan */
    margin: 0 auto;     /* center chart dalam card */
}
</style>
</head>

<body>

<div class="main-content">
    <h2 class="text-center text-dark mb-5 fw-bold">
        Welcome to SafeCampus Admin Dashboard
    </h2>

    <div class="row g-4">

        <!-- TOTAL LOCATIONS -->
        <div class="col-md-4">
            <a href="manage_location.php" class="card-link">
                <div class="card p-4 text-center">
                    <h5>Total Locations</h5>
                    <h1 class="fw-bold"><?= $location['total']; ?></h1>
                </div>
            </a>
        </div>

        <!-- REPORTS TODAY -->
        <div class="col-md-4">
            <a href="admin.php" class="card-link">
                <div class="card p-4 text-center">
                    <h5>Reports Today</h5>
                    <h1 class="fw-bold"><?= $today['total']; ?></h1>
                </div>
            </a>
        </div>

        <!-- UNRESOLVED ACCIDENT -->
        <div class="col-md-4">
            <a href="admin.php" class="card-link">
                <div class="card p-4 text-center">
                    <h5>Unresolved Accidents</h5>
                    <h1 class="fw-bold text-danger"><?= $unresolved['total']; ?></h1>
                </div>
            </a>
        </div>

    </div>

    <!-- CHART SECTION (TAMBAHAN SAHAJA) -->
    <div class="row mt-5">
        <div class="col-md-8 mx-auto">
            <div class="card p-4">
                <h5 class="text-center fw-bold mb-4">
                    Report Status Overview
                </h5>
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

</div>

<script>
const ctx = document.getElementById('statusChart');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($statusLabels); ?>,
        datasets: [{
            data: <?= json_encode($statusData); ?>,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

</body>
</html>
