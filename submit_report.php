<?php
// ==========================
// CONNECT DATABASE
// ==========================
$conn = new mysqli("localhost", "root", "", "safecampus");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// ==========================
// GET POST DATA
// ==========================
$username      = isset($_POST['username']) ? trim($_POST['username']) : '';
$incident_type = isset($_POST['incident_type']) ? trim($_POST['incident_type']) : '';
$description   = isset($_POST['description']) ? trim($_POST['description']) : '';
$location      = isset($_POST['location']) ? trim($_POST['location']) : '';
$latitude      = isset($_POST['latitude']) ? floatval($_POST['latitude']) : 0;
$longitude     = isset($_POST['longitude']) ? floatval($_POST['longitude']) : 0;

// ==========================
// VALIDATION
// ==========================
if ($username == '' || $incident_type == '' || $location == '') {
    // Kalau ada error, redirect balik ke form dengan alert
    echo "<script>alert('Missing required fields'); window.history.back();</script>";
    exit;
}

// ==========================
// INSERT INTO reports
// ==========================
// Guna timestamp NOW() dan status default 'unresolved'
$status = 'unresolved';
$stmt = $conn->prepare(
    "INSERT INTO reports 
    (username, incident_type, description, location, latitude, longitude, timestamp, status)
    VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)"
);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
    "ssssdds",
    $username,
    $incident_type,
    $description,
    $location,
    $latitude,
    $longitude,
    $status
);

// ==========================
// EXECUTE & REDIRECT
// ==========================
if ($stmt->execute()) {
    // Report berjaya submit → redirect ke dashboard
    header("Location: admin.php");
    exit;
} else {
    echo "<script>alert('Failed to submit report: " . $stmt->error . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
