<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
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
    <div class="sidebar">
        <div class="logo">Dashboard</div>
        <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
        <a href="employee.php"><i class="fas fa-user-tie"></i> Employees</a>
        <a href="student.php"><i class="fas fa-user-graduate"></i> Students</a>
        <a href="user.php"><i class="fas fa-user-graduate"></i> Users</a>
        <!-- <a href="settings.php"><i class="fas fa-cog"></i> Settings</a> -->
        <a class="nav-link" href="task.php">Task Assignment</a>

    </div>

    <div class="content">
        <div class="header d-flex justify-content-between align-items-center mb-3">
            <h2>Students</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>
        </div>

        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search students by name or email...">

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="studentsTable"></tbody>
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
                        <input type="text" id="addStuName" class="form-control mb-2" placeholder="Name" required>
                        <input type="email" id="addStuEmail" class="form-control mb-2" placeholder="Email" required>
                        <input type="text" id="addStuCourse" class="form-control mb-2" placeholder="Course" required>
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
                        <input type="hidden" id="editStuId">
                        <input type="text" id="editStuName" class="form-control mb-2" placeholder="Name" required>
                        <input type="email" id="editStuEmail" class="form-control mb-2" placeholder="Email" required>
                        <input type="text" id="editStuCourse" class="form-control mb-2" placeholder="Course" required>
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let students = [];

        $(document).ready(function () {
            fetchStudents();

            $('#searchInput').on('input', function () {
                const query = $(this).val().toLowerCase();
                const filtered = students.filter(stu =>
                    stu.name.toLowerCase().includes(query) ||
                    stu.email.toLowerCase().includes(query) ||
                    stu.course.toLowerCase().includes(query)
                );
                renderStudents(filtered);
            });
        });

        function fetchStudents() {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/students',
                method: 'GET',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
                success: function (data) {
                    students = data;
                    renderStudents(data);
                },
                error: function (error) {
                    console.error('Error fetching students:', error);
                }
            });
        }

        function renderStudents(list) {
            let tableBody = '';
            list.forEach(stu => {
                tableBody += `
                    <tr>
                        <td>${stu.id}</td>
                        <td>${stu.name}</td>
                        <td>${stu.email}</td>
                        <td>${stu.course}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="openEditModal(${stu.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteStudent(${stu.id})">Delete</button>
                        </td>
                    </tr>
                `;
            });
            $('#studentsTable').html(tableBody);
        }

        $('#addStudentForm').submit(function (event) {
            event.preventDefault();
            const name = $('#addStuName').val();
            const email = $('#addStuEmail').val();
            const course = $('#addStuCourse').val();

            $.ajax({
                url: 'http://127.0.0.1:8000/api/students',
                method: 'POST',
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
                data: { name, email, course },
                success: function () {
                    fetchStudents();
                    $('#addStudentForm')[0].reset();
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

        function openEditModal(id) {
            const stu = students.find(s => s.id === id);
            if (!stu) return alert("Student not found.");

            $('#editStuId').val(stu.id);
            $('#editStuName').val(stu.name);
            $('#editStuEmail').val(stu.email);
            $('#editStuCourse').val(stu.course);
            $('#editStudentModal').modal('show');
        }

        $('#editStudentForm').submit(function (event) {
            event.preventDefault();
            const id = $('#editStuId').val();
            const name = $('#editStuName').val();
            const email = $('#editStuEmail').val();
            const course = $('#editStuCourse').val();

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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
