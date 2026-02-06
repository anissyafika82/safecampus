<?php
include 'db.php';
include 'sidebar.php'; // sidebar tetap ada
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>About SafeCampus</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #FBCFE8 0%, #C4B5FD 50%, #93C5FD 100%);
    min-height: 100vh;
    margin: 0;
    display: flex;
}

/* Sidebar tetap fixed */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 220px;
    height: 100vh;
    overflow-y: auto;
    z-index: 1000;
}

/* Content utama centered */
.main-content {
    flex: 1; /* ambil semua ruang kecuali sidebar */
    display: flex;
    flex-direction: column;
    align-items: center; /* center horizontally */
    justify-content: center; /* center vertically */
    padding: 50px 30px;
    text-align: center;
    margin-left: 220px; /* supaya sidebar tak overlap */
}

/* Button style */
.btn-custom {
    background: linear-gradient(90deg, #C4B5FD, #FBCFE8);
    color: #2C0266;
    font-weight: 600;
    border-radius: 12px;
    border: 2px solid #4B0082;
    padding: 10px 25px;
    margin: 15px 0;
    display: inline-block;
    text-decoration: none;
    transition: 0.3s;
}

.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(196,181,253,0.4);
    border-color: #2C0266;
    color: #2C0266;
}

a.home-link {
    color: #4B0082;
    font-weight: 600;
    text-decoration: none;
    margin-top: 15px;
    display: inline-block;
}
a.home-link:hover {
    text-decoration: underline;
}
</style>
</head>
<body>

<div class="main-content">
    <h2>About SafeCampus</h2>
    <p>Developed by:</p>
<ul style="list-style: none; padding-left: 0; text-align: center;">
    <li><b>NUR ANIS SYAFIKA BINTI ZULHAMIZI (2023406052)</b></li>
    <li><b>NNORSHAMIERA BINTI MAT ZIN (2023213842)</b></li>
    <li><b>AI’NAA AMANI BINTI HATTA (2023492248)</b></li>
</ul>


    <a href="https://github.com/anissyafika82/safecampus" class="btn-custom">View GitHub Project</a>
    <br>

    <div class="footer">
        &copy; <?= date('Y') ?> SafeCampus. All Rights Reserved.
    </div>
</div>

</body>
</html>
