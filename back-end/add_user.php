<?php
include 'db.php';
session_start();

// Check admin login
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $name       = $_POST['name'];
    $username   = $_POST['username'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $birthdate  = $_POST['birthdate'];
    $gender     = $_POST['gender'];
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO registration 
            (name, username, email, phone, birthdate, gender, password)
            VALUES 
            ('$name', '$username', '$email', '$phone', '$birthdate', '$gender', '$password')";

    if ($conn->query($sql)) {
        header("Location: view_users.php");
        exit;
    } else {
        $error = "Failed to add user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add User - Admin Panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
body {
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg, #E0BBE4, #FBCFE8, #CDE7FF);
    min-height: 100vh;
    margin: 0;
    display: flex;
}

/* Sidebar inclusion via sidebar.php */
.main-content {
    flex-grow: 1;
    padding: 40px 30px;
}

.container-card {
    max-width: 700px;
    margin: auto;
    background: rgba(255,255,255,0.95);
    padding: 30px 40px;
    border-radius: 16px;
    box-shadow: 0 6px 25px rgba(0,0,0,.15);
    transition: 0.3s;
}
.container-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,.2);
}

h3 {
    text-align: center;
    margin-bottom: 30px;
    color: #4B0082;
    font-weight: 600;
}

input.form-control,
select.form-control {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 10px;
}

button.btn-success {
    background: #A78BFA;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
}
button.btn-success:hover { background: #7C3AED; }

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

.alert-danger {
    border-radius: 8px;
}
</style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <div class="container-card">
        <h3>Add New User</h3>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="add_user.php">

            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>

            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>

            <div class="mb-3">
                <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
            </div>

            <div class="mb-3">
                <input type="date" name="birthdate" class="form-control" required>
            </div>

            <div class="mb-3">
                <select name="gender" class="form-control" required>
                    <option value="">-- Select Gender --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <!-- Buttons -->
        
            <a href="view_users.php" class="btn btn-secondary">
                Cancel
            </a>

             <button type="submit" name="submit" class="btn btn-success">
                Add User
            </button>

        </form>
    </div>
</div>

</body>
</html>
