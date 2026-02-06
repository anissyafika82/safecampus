<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// LOGIN SIMPLE (boleh upgrade nanti)
if ($username === "admin" && $password === "admin123") {
    $_SESSION['admin'] = true;
    header("Location: admin.php");
} else {
    echo "Login failed";
}
