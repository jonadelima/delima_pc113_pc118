
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body { background-color: #f8f9fa; margin: 0; padding: 0; }

    .sidebar {
      height: 100vh;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #343a40;
      color: white;
      padding-top: 20px;
    }

    .sidebar a {
      display: block;
      color: white;
      padding: 15px;
      text-decoration: none;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    .content {
      margin-left: 250px;
      padding: 20px;
    }

    .topbar {
      background-color: #fff;
      padding: 15px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-left: 250px;
    }

    .profile {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .profile i {
      font-size: 1.5rem;
    }

    .logo {
      font-weight: bold;
      font-size: 1.2rem;
      padding-left: 20px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div class="logo">Dashboard</div>
  <a href="dashboard.php"><i class="bi bi-house-door"></i> Dashboard</a>
  <a href="user.php"><i class="bi bi-people"></i> Users</a>
  <a href="task.php"><i class="bi bi-journal-check"></i> Tasks</a>
  <a href="submission.php"><i class="bi bi-file-earmark-arrow-up"></i> Submissions</a>
  <a href="notification.php"><i class="bi bi-bell"></i> Notifications</a>
  <a href="index.php" onclick="logout()"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>         