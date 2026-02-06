<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "safecampus");
if ($conn->connect_error) {
    echo json_encode(["error" => "DB connection failed"]);
    exit;
}

$sql = "SELECT id, locationName, latitude, longitude FROM location";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => $conn->error]);
    exit;
}

$locations = [];

while ($row = $result->fetch_assoc()) {
    $locations[] = [
        "id" => $row["id"],
        "location_name" => $row["locationName"],
        "latitude" => $row["latitude"],
        "longitude" => $row["longitude"]
    ];
}

echo json_encode($locations);
$conn->close();
