<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
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
        <a href="user.php"><i class="fas fa-users"></i> Users</a>
    </div>

    <div class="content">
        <div class="header d-flex justify-content-between align-items-center mb-3">
            <h2>Users</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
        </div>

        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search users by name or email...">

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="usersTable"></tbody>
        </table>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <input type="text" id="addUserName" class="form-control mb-2" placeholder="Name" required>
                        <input type="email" id="addUserEmail" class="form-control mb-2" placeholder="Email" required>
                        <input type="text" id="addUserRole" class="form-control mb-2" placeholder="Role" required>
                        <button type="submit" class="btn btn-success w-100">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="editUserId">
                        <input type="text" id="editUserName" class="form-control mb-2" placeholder="Name" required>
                        <input type="email" id="editUserEmail" class="form-control mb-2" placeholder="Email" required>
                        <input type="text" id="editUserRole" class="form-control mb-2" placeholder="Role" required>
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

$(document).ready(function () {
    // Fetch and display users
    function loadUsers() {
        $.get('http://localhost:8000/api/users', function (users) {
            let rows = '';
            users.forEach((user, index) => {
                rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.role}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn" data-id="${user.id}" data-name="${user.name}" data-email="${user.email}" data-role="${user.role}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${user.id}">Delete</button>
                        </td>
                    </tr>
                `;
            });
            $('#usersTable').html(rows);
        });
    }

    loadUsers();

    // Add User
    $('#addUserForm').submit(function (e) {
        e.preventDefault();

        const data = {
            name: $('#addUserName').val(),
            email: $('#addUserEmail').val(),
            role: $('#addUserRole').val()
        };

        $.ajax({
            url: 'http://localhost:8000/api/users',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function (response) {
                $('#addUserModal').modal('hide');
                loadUsers();
                alert(response.message);
                $('#addUserForm')[0].reset();
            },
            error: function (xhr) {
                alert('Error adding user: ' + xhr.responseJSON.message);
            }
        });
    });

    // Open Edit Modal
    $(document).on('click', '.edit-btn', function () {
        $('#editUserId').val($(this).data('id'));
        $('#editUserName').val($(this).data('name'));
        $('#editUserEmail').val($(this).data('email'));
        $('#editUserRole').val($(this).data('role'));
        $('#editUserModal').modal('show');
    });

    // Update User
    $('#editUserForm').submit(function (e) {
        e.preventDefault();

        const id = $('#editUserId').val();
        const data = {
            name: $('#editUserName').val(),
            email: $('#editUserEmail').val(),
            role: $('#editUserRole').val()
        };

        $.ajax({
            url: `http://localhost:8000/api/users/${id}`,
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function (response) {
                $('#editUserModal').modal('hide');
                loadUsers();
                alert(response.message);
            },
            error: function (xhr) {
                alert('Error updating user: ' + xhr.responseJSON.message);
            }
        });
    });

    // Delete User
    $(document).on('click', '.delete-btn', function () {
        if (confirm('Are you sure you want to delete this user?')) {
            const id = $(this).data('id');
            $.ajax({
                url: `http://localhost:8000/api/users/${id}`,
                type: 'DELETE',
                success: function (response) {
                    loadUsers();
                    alert(response.message);
                },
                error: function (xhr) {
                    alert('Error deleting user: ' + xhr.responseJSON.message);
                }
            });
        }
    });

    // Search Users
    $('#searchInput').on('input', function () {
        const search = $(this).val();
        $.get(`http://localhost:8000/api/users?search=${search}`, function (users) {
            let rows = '';
            users.forEach((user, index) => {
                rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.role}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn" data-id="${user.id}" data-name="${user.name}" data-email="${user.email}" data-role="${user.role}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${user.id}">Delete</button>
                        </td>
                    </tr>
                `;
            });
            $('#usersTable').html(rows);
        });
    });
});

       
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!-- // let users = [];

// $(document).ready(function () {
//     fetchUsers();

//     $('#searchInput').on('input', function () {
//         const query = $(this).val().toLowerCase();
//         const filtered = users.filter(u =>
//             u.name.toLowerCase().includes(query) ||
//             u.email.toLowerCase().includes(query)
//         );
//         renderUsers(filtered);
//     });
// });

// function fetchUsers() {
//     $.ajax({
//         url: 'http://127.0.0.1:8000/api/users',
//         method: 'GET',
//         headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
//         success: function (data) {
//             users = data;
//             renderUsers(data);
//         },
//         error: function (error) {
//             console.error('Error fetching users:', error);
//         }
//     });
// }

// function renderUsers(list) {
//     let tableBody = '';
//     list.forEach(user => {
//         tableBody += `
//             <tr>
//                 <td>${user.id}</td>
//                 <td>${user.name}</td>
//                 <td>${user.email}</td>
//                 <td>${user.role}</td>
//                 <td>
//                     <button class="btn btn-warning btn-sm" onclick="openEditModal(${user.id})">Edit</button>
//                     <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Delete</button>
//                 </td>
//             </tr>
//         `;
//     });
//     $('#usersTable').html(tableBody);
// }

// $('#addUserForm').submit(function (event) {
//     event.preventDefault();
//     const name = $('#addUserName').val();
//     const email = $('#addUserEmail').val();
//     const role = $('#addUserRole').val();

//     $.ajax({
//         url: 'http://127.0.0.1:8000/api/users',
//         method: 'POST',
//         headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
//         data: { name, email, role },
//         success: function () {
//             fetchUsers();
//             $('#addUserForm')[0].reset();
//             $('#addUserModal').modal('hide');
//         }
//     });
// });

// function deleteUser(id) {
//     if (!confirm("Are you sure?")) return;
//     $.ajax({
//         url: `http://127.0.0.1:8000/api/users/${id}`,
//         method: 'DELETE',
//         headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
//         success: function () {
//             fetchUsers();
//         }
//     });
// }

// function openEditModal(id) {
//     const user = users.find(u => u.id === id);
//     if (!user) return alert("User not found.");

//     $('#editUserId').val(user.id);
//     $('#editUserName').val(user.name);
//     $('#editUserEmail').val(user.email);
//     $('#editUserRole').val(user.role);
//     $('#editUserModal').modal('show');
// }

// $('#editUserForm').submit(function (event) {
//     event.preventDefault();
//     const id = $('#editUserId').val();
//     const name = $('#editUserName').val();
//     const email = $('#editUserEmail').val();
//     const role = $('#editUserRole').val();

//     $.ajax({
//         url: `http://127.0.0.1:8000/api/users/${id}`,
//         method: 'PUT',
//         headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
//         data: { name, email, role },
//         success: function () {
//             fetchUsers();
//             $('#editUserModal').modal('hide');
//         }
//     });
// }); -->
