<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include "db.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if(empty($username) || empty($password)){
    echo json_encode(["status"=>"error","message"=>"Username and password required"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM registration WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    echo json_encode(["status"=>"error","message"=>"User not found"]);
    exit;
}

$user = $result->fetch_assoc();

if(password_verify($password, $user['password'])){
    echo json_encode([
        "status"=>"success",
        "message"=>"Login successful",
        "user"=>[
            "id"=>$user['id'],
            "username"=>$user['username'],
            "email"=>$user['email']
        ]
    ]);
} else {
    echo json_encode(["status"=>"error","message"=>"Incorrect password"]);
}

$stmt->close();
$conn->close();
?>
