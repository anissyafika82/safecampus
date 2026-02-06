<?php
session_start();

// buang semua session
session_unset();
session_destroy();

// redirect balik ke login page
header("Location: admin_login.php");
exit;
