<?php
include 'db.php';
session_start();

// Pastikan admin login
if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Pilihan type lokasi
$location_types = [
    'Building','Park','Cafeteria','Laboratory','Library','Dormitory',
    'Sports Complex','Office','Parking Lot','Garden','Medical Center',
    'Auditorium','Bus Stop','Security Post','Shuttle Station','Other',
    'Emergency','Clinic','Security'
];

// Handle form submission
if(isset($_POST['submit'])){
    $name = trim($conn->real_escape_string($_POST['name']));
    $type = trim($conn->real_escape_string($_POST['type']));
    $latitude = trim($conn->real_escape_string($_POST['latitude']));
    $longitude = trim($conn->real_escape_string($_POST['longitude']));
    $timestamp = date('Y-m-d H:i:s');

    // Validasi input
    if(empty($name) || empty($type) || empty($latitude) || empty($longitude)){
        $error = "Please fill in all fields.";
    } else {
        // Insert ke database
        $sql = "INSERT INTO locations (name, type, latitude, longitude, created_at)
                VALUES ('$name', '$type', '$latitude', '$longitude', '$timestamp')";
        if($conn->query($sql)){
            // Redirect ke manage_locations tanpa error
            header("Location: manage_location.php");
            exit;
        } else {
            $error = "Failed to add location: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Location - SafeCampus Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family:'Poppins',sans-serif; background:#F3F4F6; padding:50px; }
.container { max-width:600px; margin:auto; background:#fff; padding:30px; border-radius:16px; box-shadow:0 4px 15px rgba(0,0,0,.1);}
h3 { text-align:center; color:#4B0082; margin-bottom:25px; }
label { font-weight:600; color:#4B0082; }
input, select { border-radius:8px; border:1px solid #ccc; padding:10px; width:100%; margin-bottom:15px; }
button { background:#A78BFA; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:500; }
button:hover { background:#7C3AED; }
a { text-decoration:none; margin-left:10px; color:#fff; background:#F472B6; padding:10px 20px; border-radius:8px; }
a:hover { background:#DB2777; }
.error { color:red; margin-bottom:15px; }
</style>
</head>
<body>

<div class="container">
    <h3>Add New Location</h3>

    <?php if(isset($error)) echo "<div class='error'>{$error}</div>"; ?>

    <form method="POST">
        <label>Location Name</label>
        <input type="text" name="name" required>

        <label>Type</label>
        <select name="type" required>
            <option value="">--Select Type--</option>
            <?php
            foreach($location_types as $t){
                echo "<option value='" . htmlspecialchars($t) . "'>" . htmlspecialchars($t) . "</option>";
            }
            ?>
        </select>

        <label>Latitude</label>
        <input type="text" name="latitude" required>

        <label>Longitude</label>
        <input type="text" name="longitude" required>

        <div class="d-flex">
            <button type="submit" name="submit">Add Location</button>
            <a href="manage_location.php">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>
