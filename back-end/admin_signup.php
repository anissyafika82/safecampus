<?php
include 'db.php';
session_start();

if(isset($_SESSION['admin'])) {
    header("Location: view_user.php");
    exit;
}

if(isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if($password !== $confirm_password) {
        $error = "Password does not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        if($stmt->execute()) {
            $success = "Admin account created successfully. You can login now.";
        } else {
            $error = "Error: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Sign Up</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Roboto',sans-serif;}
body {height:100vh; display:flex; justify-content:center; align-items:center; background: linear-gradient(135deg, #D8B4FE 0%, #FBCFE8 50%, #93C5FD 100%);}
.wrapper {width:500px; display:flex; flex-direction:column; gap:20px; align-items:center;}
.card {background:#fff; padding:35px 30px; border-radius:16px; box-shadow:0 12px 30px rgba(0,0,0,0.12); width:100%; display:flex; flex-direction:column; gap:15px;}
.card h1 {text-align:center; color:#4B0082; font-size:22px; margin-bottom:5px;} /* Welcome Text */
.card h2 {text-align:center; margin-bottom:20px; color:#333;}
.card input {padding:12px 14px; border-radius:8px; border:1px solid #ccc; font-size:14px; outline:none; transition:0.2s;}
.card input:focus {border-color:#C4B5FD; box-shadow:0 0 6px rgba(196,181,253,0.5);}
.card button {padding:12px; border:none; border-radius:8px; background:linear-gradient(90deg, #C4B5FD, #FBCFE8); color:#444; font-size:16px; font-weight:500; cursor:pointer; transition:0.3s;}
.card button:hover {transform:translateY(-2px); box-shadow:0 6px 15px rgba(196,181,253,0.4);}
.links {font-size:13px; text-align:center; margin-top:12px;}
.links a {color:#8B5CF6; text-decoration:none;}
.links a:hover {text-decoration:underline;}
.message {text-align:center; font-size:14px; color:red;}
.success {color:green;}
</style>
</head>
<body>

<div class="wrapper">
    <div class="card">
        <!-- Welcome Message -->
        <h1>Welcome to Safe Campus</h1>

        <!-- Admin Sign Up Title -->
        <h2>Admin Sign Up</h2>

        <?php if(isset($error)){ echo "<div class='message'>$error</div>"; } ?>
        <?php if(isset($success)){ echo "<div class='message success'>$success</div>"; } ?>

        <form method="POST" style="display:flex; flex-direction:column; gap:15px;">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <!-- BUTTON BELOW CONFIRM PASSWORD -->
            <button type="submit" name="signup">Sign Up</button>
        </form>

        <div class="links">
            <a href="admin_login.php">Already have an account? Login</a>
        </div>
    </div>
</div>

</body>
</html>
