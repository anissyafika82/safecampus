<div class="bg-dark text-white p-3 sidebar">
    <h4 class="text-center mb-4">SafeCampus</h4>

    <ul class="nav nav-pills flex-column gap-2">
      <li class="nav-item">
        <a href="dashboard.php" class="nav-link text-white">🏠 Dashboard</a>
      </li>
      <li class="nav-item">
        <a href="view_users.php" class="nav-link text-white">👥 Users</a>
      </li>
      <li class="nav-item">
        <a href="admin.php#reports" class="nav-link text-white">🚨 Reports</a>
      </li>
      <li class="nav-item">
        <a href="manage_location.php" class="nav-link text-white"> 📍Locations</a>
      </li>
      <li class="nav-item">
        <a href="about.php" class="nav-link text-white">ℹ️ About</a>
      </li>
      <li class="nav-item mt-4">
        <a href="logout.php" class="nav-link text-danger">🚪 Logout</a>
      </li>
    </ul>
</div>

<style>
/* Sidebar statik di kiri */
.sidebar {
    position: fixed;   /* kekal di sisi skrin */
    top: 0;            /* mula dari atas */
    left: 0;           /* di kiri */
    width: 220px;      /* lebar sama macam awak set */
    height: 100vh;     /* tinggi penuh viewport */
    overflow-y: auto;  /* kalau isi banyak, boleh scroll dalam sidebar */
    z-index: 1000;     /* supaya sentiasa atas content */
}

/* Content utama perlu ada margin kiri supaya tak tertutup sidebar */
.main-content {
    margin-left: 220px; /* sama dengan width sidebar */
    padding: 40px;
}
</style>
