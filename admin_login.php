<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Safe Campus Admin Login</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
/* RESET */
* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Roboto', sans-serif; }

body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #D8B4FE 0%, #FBCFE8 50%, #93C5FD 100%);
}

/* WRAPPER */
.login-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    width: 500px;
}

/* WELCOME CARD */
.welcome-card {
    text-align: center;
    color: #444;
    background: rgba(255, 255, 255, 0.65);
    padding: 25px 20px;
    border-radius: 16px;
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.welcome-card h1 {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 8px;
    color: #333;
}

.welcome-card p {
    font-size: 14px;
    color: #555;
}

/* LOGIN CARD */
.login-card {
    background: #fff;
    padding: 35px 30px;
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.login-card h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

/* FORM FIELDS */
.login-card form {
    display: flex;
    flex-direction: column;
    gap: 15px; /* consistent spacing between inputs & button */
}

.login-card input {
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    outline: none;
    transition: all 0.2s;
}

.login-card input:focus {
    border-color: #C4B5FD; /* pastel purple */
    box-shadow: 0 0 6px rgba(196,181,253,0.5);
}

.login-card button {
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(90deg, #C4B5FD, #FBCFE8);
    color: #444;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
}

.login-card button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(196,181,253,0.4);
}

/* LINKS */
.login-links {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    margin-top: 10px; /* spacing from button */
}

.login-links a {
    color: #8B5CF6; /* pastel purple */
    text-decoration: none;
    transition: 0.2s;
}

.login-links a:hover {
    text-decoration: underline;
}

/* FOOTER */
.login-footer {
    text-align: center;
    font-size: 12px;
    color: #666;
    margin-top: 12px;
}

</style>
</head>
<body>

<div class="login-wrapper">

    <!-- WELCOME -->
    <div class="welcome-card">
        <h1>Welcome to Safe Campus</h1>
        <p>Manage your campus safely and efficiently</p>
    </div>

    <!-- LOGIN FORM -->
    <div class="login-card">
        <h2>Admin Login</h2>
        <form action="admin_auth.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <!-- BUTTON BELOW PASSWORD -->
            <button type="submit">Login</button>
        </form>
        <div class="login-links">
            <a href="admin_signup.php">Sign Up</a>
            <a href="forgot_password.php">Forgot Password?</a>
        </div>
    </div>

    <div class="login-footer">
        &copy; 2026 SafeCampus Admin
    </div>

</div>

</body>
</html>
