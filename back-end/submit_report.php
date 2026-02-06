<?php
header('Content-Type: application/json');

// ==========================
// CONNECT DATABASE
// ==========================
$conn = new mysqli("localhost", "root", "", "safecampus");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB connection failed"]);
    exit;
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
$timestamp     = isset($_POST['timestamp']) ? trim($_POST['timestamp']) : '';

// ==========================
// VALIDATION
// ==========================
if ($username == '' || $incident_type == '' || $location == '' || $timestamp == '') {
    echo json_encode(["status" => "error", "message" => "Missing required data"]);
    exit;
}

// ==========================
// INSERT INTO reports
// ==========================
$stmt = $conn->prepare(
    "INSERT INTO reports 
    (username, incident_type, description, location, latitude, longitude, timestamp)
    VALUES (?, ?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param(
    "ssssdds",
    $username,
    $incident_type,
    $description,
    $location,
    $latitude,
    $longitude,
    $timestamp
);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Report submitted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Insert failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
