<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$conn = new mysqli("localhost", "root", "", "safecampus");

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "status" => "error",
        "message" => "Database connection failed"
    ]));
}

// Get POST data
$name       = $_POST['name'] ?? '';
$username   = $_POST['username'] ?? '';
$email      = $_POST['email'] ?? '';
$phone      = $_POST['phone'] ?? '';
$password   = $_POST['password'] ?? '';
$birthdate  = $_POST['birthdate'] ?? '';
$gender     = $_POST['gender'] ?? '';

// Validate
if (
    empty($name) || empty($username) || empty($email) ||
    empty($phone) || empty($password) || empty($birthdate) || empty($gender)
) {
    echo json_encode([
        "status" => "error",
        "message" => "All fields are required"
    ]);
    exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert data
$sql = "INSERT INTO registration (name, username, email, phone, password, birthdate, gender)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssss",
    $name,
    $username,
    $email,
    $phone,
    $hashedPassword,
    $birthdate,
    $gender
);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Registration successful"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Registration failed"
    ]);
}

$stmt->close();
$conn->close();
?>