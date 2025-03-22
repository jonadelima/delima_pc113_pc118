<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <style>
        body {
            display: flex;
            height: 100vh;
            background-color: #1a1a2e;
            font-family: 'Poppins', sans-serif;
            color: white;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            background: #3a0ca3;
            color: white;
            padding-top: 1rem;
            position: fixed;
            transition: all 0.3s;
            box-shadow: 5px 0px 15px rgba(0, 0, 0, 0.3);
        }

        .sidebar .logo {
            text-align: center;
            font-size: 1.7rem;
            font-weight: bold;
            padding-bottom: 1rem;
        }

        .sidebar a {
            color: white;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 1.2rem;
            transition: 0.3s;
        }

        .sidebar a i {
            margin-right: 12px;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .content {
            margin-left: 260px;
            padding: 30px;
            flex-grow: 1;
            width: 100%;
            transition: all 0.3s;
            background-color: #0f3460;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h2 {
            font-size: 1.8rem;
            color: #e0aaff;
        }

        .logout-btn {
            background-color: #e94560;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background-color: #b5179e;
        }

        .table thead {
            background-color: #5a189a;
            color: white;
        }

        .table tbody tr {
            background-color: #3c096c;
            color: white;
        }
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar">
        <div class="logo">Dashboard</div>
        <a href="#"><i class="fas fa-home"></i> Home</a>
        <a href="#"><i class="fas fa-users"></i> Users</a>
        <a href="#"><i class="fas fa-user-tie"></i> Employees</a>
        <a href="#"><i class="fas fa-user-graduate"></i> Students</a>
        <button onclick="logout()" class="logout-btn w-100 mt-3"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </div>

    <div class="content">
        <div class="header">
            <h2>Welcome to Your Dashboard</h2>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                </tr>
            </thead>
            <tbody>
                <!-- Students data will be fetched here -->
            </tbody>
        </table>
    </div>

    <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            fetchStudents();
        });

        function fetchStudents() {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/students',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                success: function (data) {
                    let tableBody = '';
                    data.forEach(student => {
                        tableBody += `
                            <tr>
                                <td>${student.id}</td>
                                <td>${student.name}</td>
                                <td>${student.email}</td>
                                <td>${student.course}</td>
                            </tr>
                        `;
                    });
                    $('.table tbody').html(tableBody);
                },
                error: function (error) {
                    console.error('Error fetching students:', error);
                }
            });
        }

        function logout() {
            const token = localStorage.getItem("token");
            if (!token) {
                window.location.href = "index.php";
                return;
            }
            $.ajax({
                url: "http://127.0.0.1:8000/api/logout",
                method: "POST",
                headers: {
                    "Authorization": "Bearer " + token,
                    "Content-Type": "application/json"
                },
                success: function () {
                    localStorage.removeItem("token");
                    window.location.href = "index.php";
                },
                error: function () {
                    localStorage.removeItem("token");
                    window.location.href = "index.php";
                }
            });
        }
    </script>
</body>
</html>
