<?php
include 'db.php';
session_start();

// Pastikan admin login
if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Ambil daftar user untuk dropdown
$users_res = $conn->query("SELECT username FROM registration ORDER BY username ASC");

// Handle form submit
if(isset($_POST['submit'])) {
    $username      = $_POST['username'];
    $incident_type = $_POST['incident_type'];
    $description   = $_POST['description'];
    $location      = $_POST['location'];
    $latitude      = $_POST['latitude'];
    $longitude     = $_POST['longitude'];
    $status        = $_POST['status'];

    // Validasi sederhana
    if(empty($username) || empty($incident_type) || empty($description) || empty($location) || empty($latitude) || empty($longitude)) {
        $error = "All fields are required!";
    } else {
        // Set timezone Malaysia
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $timestamp = date('Y-m-d H:i:s');

        $conn->query("INSERT INTO reports 
            (username, incident_type, description, location, latitude, longitude, status, timestamp) 
            VALUES 
            ('$username', '$incident_type', '$description', '$location', '$latitude', '$longitude', '$status', '$timestamp')");

        header("Location: admin.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Report</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E0BBE4, #FBCFE8, #CDE7FF);
    min-height: 100vh;
    margin: 0;
    display: flex;
}
.main-content {
    flex-grow: 1;
    padding: 50px 20px;
}
.container {
    max-width: 700px;
    margin: auto;
    background: #fff;
    padding: 30px 40px;
    border-radius: 16px;
    box-shadow: 0 6px 25px rgba(0,0,0,.15);
    transition: 0.3s;
}
.container:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,.2);
}
h3 {
    text-align: center;
    margin-bottom: 30px;
    color: #4B0082;
    font-weight: 600;
}
label {
    font-weight: 500;
    color: #4B0082;
}
input.form-control,
textarea.form-control,
select.form-control {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 10px;
}
textarea.form-control { min-height: 100px; }
button.btn-primary {
    background: #A78BFA;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
}
button.btn-primary:hover { background: #7C3AED; }
a.btn-secondary {
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    background: #F472B6;
    color: #fff;
    font-weight: 500;
    margin-left: 10px;
}
a.btn-secondary:hover { background: #DB2777; }
.error-msg {
    color: red;
    margin-bottom: 15px;
    font-weight: 500;
}
</style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <h3>Add New Report</h3>

        <?php if(isset($error)) { echo "<div class='error-msg'>$error</div>"; } ?>

        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <select name="username" class="form-control" required>
                    <option value="">-- Select User --</option>
                    <?php while($u = $users_res->fetch_assoc()) { ?>
                        <option value="<?= htmlspecialchars($u['username']) ?>"><?= htmlspecialchars($u['username']) ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Incident Type</label>
                <input type="text" name="incident_type" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label>Location</label>
                <input type="text" name="location" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Latitude</label>
                <input type="number" step="any" name="latitude" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Longitude</label>
                <input type="number" step="any" name="longitude" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Resolved">Resolved</option>
                    <option value="Unresolved">Unresolved</option>
                </select>
            </div>

            <a href="admin.php" class="btn btn-secondary">Cancel</a>
            <button type="submit" name="submit" class="btn btn-primary">Add</button>

        </form>
    </div>
</div>

</body>
</html>
