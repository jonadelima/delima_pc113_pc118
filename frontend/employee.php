<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    <div class="sidebar">
        <div class="logo">Dashboard</div>
        <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
        <a href="employee.php"><i class="fas fa-user-tie"></i> Employees</a>
        <a href="student.php"><i class="fas fa-user-graduate"></i> Students</a>
        <a href="user.php"><i class="fas fa-user-graduate"></i> Users</a>
        <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>

    </div>

    <div class="content">
        <div class="header d-flex justify-content-between align-items-center mb-3">
            <h2>Employees</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add Employee</button>
        </div>

        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search employees by name or email...">

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="employeesTable"></tbody>
        </table>
    </div>

    <!-- Add Employee Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addEmployeeForm">
                        <input type="text" id="addEmpName" class="form-control mb-2" placeholder="Name" required>
                        <input type="email" id="addEmpEmail" class="form-control mb-2" placeholder="Email" required>
                        <input type="text" id="addEmpPosition" class="form-control mb-2" placeholder="Position" required>
                        <button type="submit" class="btn btn-success w-100">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editEmployeeForm">
                        <input type="hidden" id="editEmpId">
                        <input type="text" id="editEmpName" class="form-control mb-2" placeholder="Name" required>
                        <input type="email" id="editEmpEmail" class="form-control mb-2" placeholder="Email" required>
                        <input type="text" id="editEmpPosition" class="form-control mb-2" placeholder="Position" required>
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let employees = [];

        $(document).ready(function () {
            fetchEmployees();

            $('#searchInput').on('input', function () {
                const query = $(this).val().toLowerCase();
                const filtered = employees.filter(emp =>
                    emp.name.toLowerCase().includes(query) ||
                    emp.email.toLowerCase().includes(query)
                );
                renderEmployees(filtered);
            });
        });

        function fetchEmployees() {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/employees',
                method: 'GET',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
                success: function (data) {
                    employees = data;
                    renderEmployees(data);
                },
                error: function (error) {
                    console.error('Error fetching employees:', error);
                }
            });
        }

        function renderEmployees(list) {
            let tableBody = '';
            list.forEach(emp => {
                tableBody += `
                    <tr>
                        <td>${emp.id}</td>
                        <td>${emp.name}</td>
                        <td>${emp.email}</td>
                        <td>${emp.position}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="openEditModal(${emp.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteEmployee(${emp.id})">Delete</button>
                        </td>
                    </tr>
                `;
            });
            $('#employeesTable').html(tableBody);
        }

        $('#addEmployeeForm').submit(function (event) {
    event.preventDefault();
    const name = $('#addEmpName').val();
    const email = $('#addEmpEmail').val();
    const position = $('#addEmpPosition').val();

    $.ajax({
        url: 'http://127.0.0.1:8000/api/employees',
        method: 'POST',
        headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
        data: { name, email, position },
        success: function () {
            fetchEmployees();
            $('#addEmployeeForm')[0].reset();
            $('#addEmployeeModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Employee Added!',
                text: `${name} has been successfully added.`,
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
});


function deleteEmployee(id) {
    const emp = employees.find(e => e.id === id);
    if (!emp) return Swal.fire('Error', 'Employee not found.', 'error');

    Swal.fire({
        title: `Delete ${emp.name}?`,
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `http://127.0.0.1:8000/api/employees/${id}`,
                method: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
                success: function () {
                    fetchEmployees();
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: `${emp.name} has been deleted.`,
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }
    });
}

        function openEditModal(id) {
            const emp = employees.find(e => e.id === id);
            if (!emp) return alert("Employee not found.");

            $('#editEmpId').val(emp.id);
            $('#editEmpName').val(emp.name);
            $('#editEmpEmail').val(emp.email);
            $('#editEmpPosition').val(emp.position);
            $('#editEmployeeModal').modal('show');
        }

        $('#editEmployeeForm').submit(function (event) {
            event.preventDefault();
            const id = $('#editEmpId').val();
            const name = $('#editEmpName').val();
            const email = $('#editEmpEmail').val();
            const position = $('#editEmpPosition').val();

            $.ajax({
                url: `http://127.0.0.1:8000/api/employees/${id}`,
                method: 'PUT',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
                data: { name, email, position },
                success: function () {
                    fetchEmployees();
                    $('#editEmployeeModal').modal('hide');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
