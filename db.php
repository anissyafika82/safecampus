<?php
$conn = new mysqli("localhost", "root", "", "safecampus");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
