<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Employees</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body {
      margin: 0;
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }

    .sidebar {
      width: 250px;
      background: #343a40;
      color: white;
      height: 100vh;
      position: fixed;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 20px;
    }

    .sidebar .logo {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 30px;
      text-align: center;
    }

    .sidebar a {
      color: white;
      padding: 12px 20px;
      width: 100%;
      display: flex;
      align-items: center;
      text-decoration: none;
      transition: background 0.3s;
    }

    .sidebar a i {
      margin-right: 10px;
      font-size: 18px;
    }

    .sidebar a:hover {
      background: #495057;
    }

    .main {
      margin-left: 250px;
    }

    .topbar {
      background-color: #ffffff;
      padding: 10px 20px;
      border-bottom: 1px solid #dee2e6;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .topbar .profile {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .content {
      padding: 20px;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div class="logo">Dashboard</div>
  <a href="dashboard.php"><i class="bi bi-house-door"></i> Dashboard</a>
  <a href="employee.php"><i class="bi bi-person-badge"></i> Employees</a>
  <a href="student.php"><i class="bi bi-mortarboard"></i> Students</a>
  <a href="user.php"><i class="bi bi-people"></i> Users</a>
  <a href="task.php"><i class="bi bi-journal-check"></i> Task Management</a>
  <a href="submission.php"><i class="bi bi-file-earmark-arrow-up"></i> Submissions</a>
  <a href="notification.php"><i class="bi bi-bell"></i> Notifications</a>
  <a href="#" onclick="logout()"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="main">
  <div class="topbar">
    <h4 class="mb-0">Employees</h4>
    <div class="profile">
      <i class="bi bi-person-circle fs-4"></i>
      <span id="userRole">Admin</span>
    </div>
  </div>

  <div class="content">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add Employee</button>
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search employees by name or email...">

    <table class="table table-bordered">
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
        </tr>`;
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

</body>
</html>
         