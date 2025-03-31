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
        <a href="#"><i class="fas fa-home"></i> Home</a>
        <a href="#"><i class="fas fa-users"></i> Users</a>
        <a href="#"><i class="fas fa-user-tie"></i> Employees</a>
        <a href="#"><i class="fas fa-user-graduate"></i> Students</a>
        <button onclick="logout()" class="logout-btn w-100 mt-3"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </div>

    <div class="content">
        <div class="header d-flex justify-content-between">
            <h2>Welcome to Your Dashboard</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="studentsTable">
                <!-- Student Data Will Load Here -->
            </tbody>
        </table>
    </div>

    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addStudentForm">
                        <input type="text" id="addName" class="form-control mb-2" placeholder="Name" required>
                        <input type="email" id="addEmail" class="form-control mb-2" placeholder="Email" required>
                        <input type="text" id="addCourse" class="form-control mb-2" placeholder="Course" required>
                        <button type="submit" class="btn btn-success w-100">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editStudentForm">
                        <input type="hidden" id="editId">
                        <input type="text" id="editName" class="form-control mb-2" placeholder="Name" required>
                        <input type="email" id="editEmail" class="form-control mb-2" placeholder="Email" required>
                        <input type="text" id="editCourse" class="form-control mb-2" placeholder="Course" required>
                        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                            <tr id="row-${student.id}">
                                <td>${student.id}</td>
                                <td>${student.name}</td>
                                <td>${student.email}</td>
                                <td>${student.course}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editStudent(${student.id}, '${student.name}', '${student.email}', '${student.course}')">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteStudent(${student.id})">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#studentsTable').html(tableBody);
                },
                error: function (error) {
                    console.error('Error fetching students:', error);
                }
            });
        }

        function editStudent(id, name, email, course) {
            $('#editId').val(id);
            $('#editName').val(name);
            $('#editEmail').val(email);
            $('#editCourse').val(course);
            $('#editStudentModal').modal('show');
        }

        $('#editStudentForm').submit(function (event) {
            event.preventDefault();
            const id = $('#editId').val();
            const name = $('#editName').val();
            const email = $('#editEmail').val();
            const course = $('#editCourse').val();

            $.ajax({
                url: `http://127.0.0.1:8000/api/students/${id}`,
                method: 'PUT',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
                data: { name, email, course },
                success: function () {
                    fetchStudents();
                    $('#editStudentModal').modal('hide');
                }
            });
        });

        $('#addStudentForm').submit(function (event) {
            event.preventDefault();
            const name = $('#addName').val();
            const email = $('#addEmail').val();
            const course = $('#addCourse').val();

            $.ajax({
                url: 'http://127.0.0.1:8000/api/students',
                method: 'POST',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
                data: { name, email, course },
                success: function () {
                    fetchStudents();
                    $('#addStudentModal').modal('hide');
                }
            });
        });

        function deleteStudent(id) {
            if (!confirm("Are you sure?")) return;
            $.ajax({
                url: `http://127.0.0.1:8000/api/students/${id}`,
                method: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
                success: function () {
                    fetchStudents();
                }
            });
        }
    </script>
</body>
</html>
