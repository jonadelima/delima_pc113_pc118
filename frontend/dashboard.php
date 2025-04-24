<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .topbar {
      background-color: #1e355e;
      padding: 1rem 2rem;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #132238;
    }
    .dashboard-title {
      font-size: 1.5rem;
      font-weight: bold;
    }
    .logout-btn {
      background: none;
      border: none;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }
    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      transition: transform 0.2s ease;
    }
    .card:hover {
      transform: scale(1.02);
    }
    .icon-box {
      width: 24px;
      height: 24px;
      margin-right: 10px;
    }
    .section-title {
      margin: 2rem 0 1rem;
      font-weight: 600;
    }
  </style>
</head>
<body>

<!-- Topbar -->
<div class="topbar">
  <div class="dashboard-title">Task Assignment</div>
  <div class="d-flex align-items-center">
    <span class="me-4">Admin</span>
    <button onclick="logout()" class="logout-btn">Logout</button>
  </div>
</div>

<!-- Dashboard Content -->
<div class="container py-4">
  <h3 class="mb-4">Dashboard</h3>

  <!-- Metrics Cards -->
  <div class="row g-3">
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <div class="d-flex justify-content-center align-items-center mb-2">
          <svg class="icon-box" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zM8 11c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13zM16 13c-.29 0-.62.02-.97.05C16.17 14.17 18 15.4 18 16.5V19h6v-2.5c0-2.33-4.67-3.5-8-3.5z"/></svg>
          <strong>5</strong>
        </div>
        <div>Total Users</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <div class="d-flex justify-content-center align-items-center mb-2">
          <svg class="icon-box" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v2H4zm0 4h10v2H4zm0 4h16v2H4zm0 4h10v2H4zm0 4h16v2H4z"/></svg>
          <strong>12</strong>
        </div>
        <div>Total Tasks</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <div class="d-flex justify-content-center align-items-center mb-2">
          <svg class="icon-box" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.2l-3.5-3.5L4 14.2l5 5L20 8.2l-1.4-1.4z"/></svg>
          <strong>8</strong>
        </div>
        <div>Total Submissions</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <div class="d-flex justify-content-center align-items-center mb-2">
          <svg class="icon-box" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm6 6h8v8h-8v-8zm2 2v4h4v-4h-4zM3 15h8v6H3v-6zm2 2v2h4v-2H5zm14-2h2v6h-6v-2h4v-4z"/></svg>
          <strong>11</strong>
        </div>
        <div>Generated QR Codes</div>
      </div>
    </div>
  </div>

  <!-- Actions -->
  <h5 class="section-title">Quick Actions</h5>
  <div class="row g-3">
    <div class="col-md-3">
      <a href="user.php" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
        <svg class="icon-box me-2" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zM8 11c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zM8 13c-2.33 0-7 1.17-7 3.5V19h6v-2.5C7 14.17 10.33 13 12 13s5 1.17 5 3.5V19h6v-2.5c0-2.33-4.67-3.5-8-3.5z"/></svg>
        Manage Users
      </a>
    </div>
    <div class="col-md-3">
      <a href="task.php" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
        <svg class="icon-box me-2" fill="currentColor" viewBox="0 0 24 24"><path d="M9 11H7v2h2v-2zm0-4H7v2h2V7zm0 8H7v2h2v-2zm4-8h8v2h-8V7zm0 4h8v2h-8v-2zm0 4h8v2h-8v-2z"/></svg>
        Assign Task
      </a>
    </div>
    <div class="col-md-3">
      <a href="submissions.php" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
        <svg class="icon-box me-2" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.2l-3.5-3.5L4 14.2l5 5L20 8.2l-1.4-1.4z"/></svg>
        View Submissions
      </a>
    </div>
    <div class="col-md-3">
      <a href="notifications.php" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
        <svg class="icon-box me-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4a2 2 0 002 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4a1.5 1.5 0 00-3 0v.68C7.63 5.36 6 7.92 6 11v5l-1.99 2L4 19h16l-.01-1L18 16z"/></svg>
        Notifications
      </a>
    </div>
    <div class="col-md-3">
      <a href="create_task.php" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
        <svg class="icon-box me-2" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5a2 2 0 00-2 2v2h18V5a2 2 0 00-2-2zm1 6H4v10a2 2 0 002 2h12a2 2 0 002-2V9z"/></svg>
        Create Task
      </a>
    </div>
    <div class="col-md-3">
      <a href="settings.php" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
        <svg class="icon-box me-2" fill="currentColor" viewBox="0 0 24 24"><path d="M19.14 12.94c.04-.31.06-.63.06-.94s-.02-.63-.06-.94l2.03-1.58a.5.5 0 00.11-.66l-1.91-3.32a.5.5 0 00-.61-.21l-2.39.96a7.007 7.007 0 00-1.6-.94l-.36-2.65A.5.5 0 0014 2h-4a.5.5 0 00-.5.42l-.36 2.65c-.58.22-1.12.52-1.6.94l-2.39-.96a.5.5 0 00-.61.21L2.72 8.88a.5.5 0 00.11.66l2.03 1.58c-.04.31-.06.63-.06.94s.02.63.06.94l-2.03 1.58a.5.5 0 00-.11.66l1.91 3.32c.14.24.44.33.68.21l2.39-.96c.48.42 1.02.72 1.6.94l.36 2.65c.03.26.24.45.5.45h4c.26 0 .47-.19.5-.45l.36-2.65c.58-.22 1.12-.52 1.6-.94l2.39.96a.5.5 0 00.61-.21l1.91-3.32a.5.5 0 00-.11-.66l-2.03-1.58z"/></svg>
        System Settings
      </a>
    </div>
  </div>
</div>

<script>
  function logout() {
    alert("Logging out...");
    window.location.href = "index.php";
  }
</script>
</body>
</html>




<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .sidebar {
      height: 100vh;
      background: #343a40;
      color: white;
      position: fixed;
      width: 250px;
    }
    .sidebar a {
      color: white;
      padding: 15px;
      display: block;
      text-decoration: none;
    }
    .sidebar a:hover {
      background: #495057;
    }
    .content {
      margin-left: 250px;
      padding: 20px;
    }
    .topbar {
      background: #ffffff;
      padding: 15px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }
    .topbar .profile {
      margin-right: 20px;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <div class="text-center py-4">
    <h4><i class="fas fa-tasks"></i> TAS</h4>
  </div>
  <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
  <a href="employee.php"><i class="fas fa-user-tie"></i> Employees</a>
  <a href="student.php"><i class="fas fa-user-graduate"></i> Students</a>
  <a href="user.php"><i class="fas fa-users"></i> Users</a>
  <a href="task.php"><i class="fas fa-tasks"></i> Task Assignment</a>
  <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
</div>

<div class="content">
  <div class="topbar">
    <div class="profile">
      <i class="fas fa-user-circle"></i> Admin
    </div>
    <button onclick="logout()" class="btn btn-danger btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</button>
  </div>
  <div class="mt-4">
    <h2>Welcome to Your Dashboard</h2>
    <p>Select an option from the sidebar to manage Employees, Students, or Tasks.</p>
  </div>
</div>

<script>
  const userRole = localStorage.getItem("role");
  if (!userRole) {
    window.location.href = "index.php";
  } else {
    console.log("Welcome " + userRole + "!");
  }

  function logout() {
    alert("Logging out...");
    window.location.href = "index.php";
  }
</script>
</body>
</html> -->



<!-- <?php
// You can add session and DB includes here if needed
?> -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      border-radius: 1rem;
    }
    .topbar {
      padding: 20px 0;
    }
    .icon {
      width: 36px;
      height: 36px;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <div class="topbar d-flex justify-content-between align-items-center mb-4">
    <div class="profile d-flex align-items-center">
      <h4 class="fw-bold mb-0">Admin</h4>
    </div>
    <button onclick="logout()" class="btn btn-outline-danger btn-sm">Logout</button>
  </div>

  <h3 class="fw-bold mb-4">Dashboard</h3>

  <div class="row g-4">

    Total Users -->
    <!-- <div class="col-md-4">
      <div class="card shadow-sm border-0 text-center p-4">
        <div class="fs-1 text-primary mb-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" stroke="#0d6efd" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="7" r="4" />
            <path d="M5.5 21h13a2 2 0 0 0 2-2a6 6 0 0 0 -12 0a2 2 0 0 0 2 2z" />
          </svg>
        </div>
        <h4>5</h4>
        <p class="mb-0">Total Users</p>
      </div>
    </div> -->

    <!-- Total Students -->
    <!-- <div class="col-md-4">
      <div class="card shadow-sm border-0 text-center p-4">
        <div class="fs-1 text-success mb-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" stroke="#198754" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 12h-4l-3 9-4-16-3 7H2" />
          </svg>
        </div>
        <h4>30</h4>
        <p class="mb-0">Total Students</p>
      </div>
    </div> -->

    <!-- Total Employees -->
    <!-- <div class="col-md-4">
      <div class="card shadow-sm border-0 text-center p-4">
        <div class="fs-1 text-warning mb-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" stroke="#ffc107" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M4 21v-2a4 4 0 0 1 3-3.87" />
            <circle cx="12" cy="7" r="4" />
          </svg>
        </div>
        <h4>12</h4>
        <p class="mb-0">Total Employees</p>
      </div>
    </div>

  </div>
</div>

<script>
  function logout() { -->
    <!-- // Optional: AJAX logout or redirect
    window.location.href = 'logout.php';
  }
</script>

</body>
</html> -->
