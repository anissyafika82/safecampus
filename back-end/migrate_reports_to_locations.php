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
// GET POST DATA (robust for form-data OR JSON)
// ==========================
$input = [];
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if (stripos($contentType, 'application/json') === 0) {
    // kalau JSON, decode body
    $input = json_decode(file_get_contents('php://input'), true);
} else {
    // kalau form-data
    $input = $_POST;
}

// DEBUG: semak apa yang masuk
// file_put_contents("php://stderr", "INPUT: " . print_r($input, true) . "\n");

$incident_type = isset($input['incident_type']) ? trim($input['incident_type']) : '';
$description   = isset($input['description']) ? trim($input['description']) : '';
$location      = isset($input['location']) ? trim($input['location']) : '';
$latitude      = isset($input['latitude']) ? floatval($input['latitude']) : 0;
$longitude     = isset($input['longitude']) ? floatval($input['longitude']) : 0;
$timestamp     = isset($input['timestamp']) ? trim($input['timestamp']) : '';

// ==========================
// VALIDATION
// ==========================
if ($incident_type == '' || $location == '' || $timestamp == '') {
    echo json_encode(["status" => "error", "message" => "Missing required data", "received" => $input]);
    exit;
}

// ==========================
// INSERT INTO reports
// ==========================
$stmt = $conn->prepare(
    "INSERT INTO reports 
    (incident_type, description, location, latitude, longitude, timestamp)
    VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param("sssdds", $incident_type, $description, $location, $latitude, $longitude, $timestamp);
$stmt->execute();
$stmt->close();

// ==========================
// INSERT INTO locations
// ==========================
$incident = strtolower($incident_type);
if ($incident == "crime") $type = "security";
elseif ($incident == "accident") $type = "emergency";
elseif ($incident == "damaged") $type = "clinic";
else $type = "other";

$check = $conn->prepare("SELECT id FROM locations WHERE name=? AND latitude=? AND longitude=?");
$check->bind_param("sdd", $location, $latitude, $longitude);
$check->execute();
$check->store_result();

if ($check->num_rows == 0) {
    $stmt_loc = $conn->prepare("INSERT INTO locations (name, type, latitude, longitude) VALUES (?, ?, ?, ?)");
    $stmt_loc->bind_param("ssdd", $location, $type, $latitude, $longitude);
    $stmt_loc->execute();
    $stmt_loc->close();
}

$check->close();
$conn->close();

echo json_encode(["status" => "success", "message" => "Report and location submitted successfully"]);
?>
