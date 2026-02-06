<?php
include 'db.php';
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Handle Delete User
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM registration WHERE id=$id");
}

// Ambil total user
$total_users_res = $conn->query("SELECT COUNT(*) as total FROM registration");
$total_users_row = $total_users_res->fetch_assoc();
$total_users = $total_users_row['total'];

// Ambil total male dan female
$total_male_res = $conn->query("SELECT COUNT(*) as total FROM registration WHERE gender='Male'");
$total_male_row = $total_male_res->fetch_assoc();
$total_male = $total_male_row['total'];

$total_female_res = $conn->query("SELECT COUNT(*) as total FROM registration WHERE gender='Female'");
$total_female_row = $total_female_res->fetch_assoc();
$total_female = $total_female_row['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Users Management</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #E0BBE4, #FBCFE8, #CDE7FF);
        min-height: 100vh;
        margin: 0;
    }

    .main-content {
        flex-grow:1;
        padding: 40px;
    }

    h3 {
        text-align: center;
        margin-bottom: 20px;
        color: #4B0082;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Total Users Cards Container */
    .cards-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    /* Total Users Card */
    .total-users-card {
        flex: 1 1 200px;
        max-width: 250px;
        background: #fff;
        border-radius: 16px;
        padding: 25px 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        text-align: center;
    }
    .total-users-card h4 {
        margin-bottom: 15px;
        font-weight: 600;
    }
    .total-users-card .number {
        font-size: 48px;
        font-weight: 700;
    }

    .total-users { color: #4B0082; }   /* Total Users */
    .total-male { color: #1E3A8A; }    /* Male - dark blue */
    .total-female { color: #DB2777; }  /* Female - pink/red */

    .btn-container {
        display: flex;
        justify-content: flex-start; 
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }

    .btn-custom {
        border-radius: 12px;
        font-weight: 600;
        padding: 10px 25px;
        text-decoration: none;
        color: #1a1a1a;
        border: 2px solid #1a1a1a;
        display: inline-block;
        transition: 0.3s;
    }

    .btn-add { 
        background: linear-gradient(90deg, #C4B5FD, #FBCFE8); 
    }
    .btn-add:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 6px 15px rgba(196,181,253,0.4); 
    }

    .btn-edit {
        background: #A78BFA;
        color: #fff;
        border-radius: 8px;
        padding: 5px 12px;
        display: inline-block;
        text-decoration: none;
        font-weight: 500;
        margin-right: 5px;
    }
    .btn-edit:hover { background: #7C3AED; }

    .btn-delete {
        background: #F472B6;
        color: #fff;
        border-radius: 8px;
        padding: 5px 12px;
        display: inline-block;
        text-decoration: none;
        font-weight: 500;
        margin-left: 5px;
    }
    .btn-delete:hover { background: #DB2777; }

    .btn-view {
        background: #60A5FA; 
        color: #fff;
        border-radius: 8px;
        padding: 5px 12px;
        display: inline-block;
        text-decoration: none;
        font-weight: 500;
        margin-right: 5px;
    }
    .btn-view:hover { background: #3B82F6; }

    .table-responsive {
        background: rgba(255,255,255,0.95);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    th {
        background: #A78BFA;
        color: #fff;
        text-align: center;
        font-weight: 600;
        padding: 12px;
        border-radius: 12px 12px 0 0;
    }

    td {
        text-align: center;
        padding: 12px;
        background: #F3F4F6;
        border-radius: 8px;
    }

    tr:hover td {
        background: #EDE9FE;
        transition: 0.3s;
    }

    @media (max-width: 768px){
        .btn-container { flex-direction: column; gap: 10px; }
        .btn-container a { width: 100%; text-align: center; }
        table { font-size: 14px; }
        .total-users-card { max-width: 100%; }
    }
</style>
</head>
<body>
<div class="d-flex">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <h3>Users Management</h3>

        <!-- Total Users Cards -->
        <div class="cards-container">
            <div class="total-users-card">
                <h4>Total Users</h4>
                <div class="number total-users"><?= $total_users ?></div>
            </div>

            <div class="total-users-card">
                <h4> Users by Gender</h4>
                <div style="display:flex; justify-content: space-around; align-items: center;">
                    <div>
                        <div class="number total-male"><?= $total_male ?></div>
                        <small>Male</small>
                    </div>
                    <div>
                        <div class="number total-female"><?= $total_female ?></div>
                        <small>Female</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="btn-container">
            <a href="add_user.php" class="btn-custom btn-add">Add User</a>
        </div>

        <!-- Users Table -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Birthdate</th>
                        <th>Gender</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $res = $conn->query("SELECT * FROM registration");
                while($u = $res->fetch_assoc()){
                    echo "<tr>
                        <td>{$u['name']}</td>
                        <td>{$u['username']}</td>
                        <td>{$u['email']}</td>
                        <td>{$u['phone']}</td>
                        <td>{$u['birthdate']}</td>
                        <td>{$u['gender']}</td>
                        <td>
                            <a href='show_user.php?id={$u['id']}' class='btn-view'>Show</a>
                            <a href='edit_user.php?id={$u['id']}' class='btn-edit'>Edit</a>
                            <a href='?delete={$u['id']}' class='btn-delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
