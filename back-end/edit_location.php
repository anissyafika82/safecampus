<?php
include 'db.php';
session_start();

// Pastikan admin login
if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Pastikan ada ID
if(!isset($_GET['id'])) {
    header("Location: manage_location.php");
    exit;
}

$id = intval($_GET['id']);
$res = $conn->query("SELECT * FROM locations WHERE id=$id");

if($res->num_rows == 0) {
    echo "Location not found!";
    exit;
}

$loc = $res->fetch_assoc();

// Pilihan type lokasi
$location_types = [
    'Crime','Emergency','Security'
];

if(isset($_POST['submit'])){
    $name = trim($conn->real_escape_string($_POST['name']));
    $type = trim($conn->real_escape_string($_POST['type']));
    $latitude = trim($conn->real_escape_string($_POST['latitude']));
    $longitude = trim($conn->real_escape_string($_POST['longitude']));

    if(empty($name) || empty($type) || empty($latitude) || empty($longitude)){
        $error = "Please fill in all fields.";
    } else {
        $sql = "UPDATE locations SET 
                name='$name', 
                type='$type', 
                latitude='$latitude', 
                longitude='$longitude',
                updated_at=NOW()
                WHERE id=$id";
        if($conn->query($sql)){
            header("Location: manage_location.php");
            exit;
        } else {
            $error = "Failed to update location: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Location - SafeCampus Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
body { font-family:'Poppins',sans-serif; background: linear-gradient(135deg, #E0BBE4, #FBCFE8, #CDE7FF); min-height:100vh; margin:0; display:flex; }
.main-content { flex-grow:1; padding:40px; }
.card-container { max-width:600px; margin:auto; background: rgba(255,255,255,0.95); padding:30px; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.1);}
h3 { text-align:center; color:#4B0082; margin-bottom:25px; }
label { font-weight:600; color:#6B21A8; }
input, select { border-radius:8px; border:1px solid #ccc; padding:10px; width:100%; margin-bottom:15px; }
button { background:#A78BFA; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:500; }
button:hover { background:#7C3AED; }
a { text-decoration:none; color:#fff; background:#F472B6; padding:10px 20px; border-radius:8px; margin-right:10px; display:inline-block;}
a:hover { background:#DB2777; }
.error { color:red; margin-bottom:15px; }
.d-flex { display:flex; justify-content:flex-end; gap:10px; }
</style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <div class="card-container">
        <h3>Edit Location</h3>

        <?php if(isset($error)) echo "<div class='error'>{$error}</div>"; ?>

        <form method="POST">
            <label>Location Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($loc['name']) ?>" required>

            <label>Type</label>
            <select name="type" required>
                <?php
                foreach($location_types as $t){
                    $selected = ($loc['type']==$t)? "selected" : "";
                    echo "<option value='" . htmlspecialchars($t) . "' $selected>" . htmlspecialchars($t) . "</option>";
                }
                ?>
            </select>

            <label>Latitude</label>
            <input type="text" name="latitude" value="<?= htmlspecialchars($loc['latitude']) ?>" required>

            <label>Longitude</label>
            <input type="text" name="longitude" value="<?= htmlspecialchars($loc['longitude']) ?>" required>

            <div class="d-flex">
                <a href="manage_location.php">Cancel</a>
                <button type="submit" name="submit">Update</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
