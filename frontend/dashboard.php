<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        body {
            display: flex;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
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
            margin-left: 260px;
            padding: 20px;
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar">
        <div class="logo">Dashboard</div>
        <a href="index.php"><i class="fas fa-home"></i> Home</a>
        <a href="employee.php"><i class="fas fa-user-tie"></i> Employees</a>
        <a href="student.php"><i class="fas fa-user-graduate"></i> Students</a>
        <button onclick="logout()" class="logout-btn w-100 mt-3"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </div>

    <div class="content">
        <h2>Welcome to Your Dashboard</h2>
        <p>Select an option from the sidebar to manage Employees or Students.</p>
    </div>

    <script>
        function logout() {
            alert("Logging out...");
            window.location.href = "index.php";
        }
    </script>
</body>
</html>
