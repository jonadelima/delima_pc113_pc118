<?php require_once('admin/header.php') ?>
<?php require_once('admin/navbar.php') ?>
<?php require_once('admin/sidebar.php') ?>
<?php require_once('admin/js.php') ?>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f8f9fa;
    }
    .sidebar {
      width: 250px;
      color: #fff;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 20px;
    }
    .sidebar .logo {
      font-size: 1.5rem;
      text-align: center;
      margin-bottom: 1rem;
      font-weight: bold;
    }
    .sidebar a {
      display: block;
      color: #fff;
      padding: 12px 20px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .main {
      margin-left: 250px;
    }
    .topbar {
      background-color: #ffffff;
      padding: 10px 20px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .topbar .profile {
      display: flex;
      align-items: center;
    }
    .topbar .profile i {
      font-size: 1.5rem;
      margin-right: 10px;
    }
    .icon-btn {
      background: none;
      border: none;
      cursor: pointer;
    }
    .icon-btn:hover {
      opacity: 0.8;
    }
  </style>
</head>
<body>


<!-- Main Content -->
<div class="main">
  <!-- Top Bar -->
  <div class="topbar">
    <h4>User Management</h4>
  </div>

  <div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4>Users</h4>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
    </div>

    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search users by name or email...">

    <table class="table table-bordered">
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
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addUserForm">
        <div class="modal-header">
          <h5 class="modal-title">Add User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" id="addUserName" class="form-control mb-2" placeholder="Name" required>
          <input type="email" id="addUserEmail" class="form-control mb-2" placeholder="Email" required>
        <select id="addUserRole" class="form-select mb-2" required>
          <option value="" disabled selected>Select a role</option>
          <option value="0">Admin</option>
          <option value="1">Teacher</option>
          <option value="2">Assistant Teacher</option>
        </select>
          <input type="password" id="addUserPassword" class="form-control mb-2" placeholder="Password" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editUserForm">
        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editUserId">
          <input type="text" id="editUserName" class="form-control mb-2" placeholder="Name" required>
          <input type="email" id="editUserEmail" class="form-control mb-2" placeholder="Email" required>
         <select id="editUserRole" class="form-select form-select-lg mb-2" aria-label="Select User Role" required>
          <option value="" disabled>Select a role</option>
          <option value="0">Admin</option>
          <option value="1">Teacher</option>
          <option value="2">Assistant Teacher</option>
        </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    

<script>
  function getRoleName(role) {
    switch (parseInt(role)) {
      case 0: return 'Admin';
      case 1: return 'Teacher';
      case 2: return 'Assistant Teacher';
      default: return 'Unknown';
    }
  }

  function loadUsers() {
    const token = localStorage.getItem('auth_token');
    const tableBody = document.querySelector('#usersTable');
    
    console.log("🔍 Starting to load users...");

    if (!token) {
      console.error("❌ No token found in localStorage. Please log in first.");
      return;
    }

    if (!tableBody) {
      console.error("❌ Table body element with ID #usersTable not found.");
      return;
    }

    fetch('http://127.0.0.1:8000/api/admin', {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })
      .then(async res => {
        console.log("✅ Server responded. Status:", res.status);

        const contentType = res.headers.get('content-type');
        if (!res.ok || !contentType || !contentType.includes('application/json')) {
          const text = await res.text();
          throw new Error(`❌ Invalid response format or status: ${res.status} | Response: ${text}`);
        }

        return res.json();
      })
      .then(result => {
        console.log("📦 Received JSON result:", result);

        // Check kung may 'users' key
        if (!result.users || !Array.isArray(result.users)) {
          console.error("❌ Unexpected response format. 'users' key missing or not an array.");
          return;
        }

        const users = result.users;
        tableBody.innerHTML = '';

        if (users.length === 0) {
          tableBody.innerHTML = '<tr><td colspan="5" class="text-center">No users found.</td></tr>';
          console.warn("⚠️ Users list is empty.");
          return;
        }

       users.forEach((user, index) => {
  if (parseInt(user.role) === 0) return; // Skip Admins

  const row = `
    <tr>
      <td>${index + 1}</td>
      <td>${user.name}</td>
      <td>${user.email}</td>
      <td>${getRoleName(user.role)}</td>
      <td>
        <button class="btn btn-warning btn-sm" onclick='editUser(${JSON.stringify(user)})'>Edit</button>
        <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Delete</button>
      </td>
    </tr>
  `;
  tableBody.innerHTML += row;
});
      })
      .catch(err => {
        console.error("❌ Error while fetching users:", err.message);
      });
  }

  // Auto-load users when page loads
  document.addEventListener('DOMContentLoaded', loadUsers);
</script>

<script>
  function editUser(user) {
    console.log("✏️ Editing user:", user);

    // Populate form fields
    document.getElementById('editUserId').value = user.id;
    document.getElementById('editUserName').value = user.name;
    document.getElementById('editUserEmail').value = user.email;
    document.getElementById('editUserRole').value = user.role;

    // Show the modal
    const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
    editModal.show();
  }

  document.getElementById('editUserForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const userId = document.getElementById('editUserId').value;
  const name = document.getElementById('editUserName').value.trim();
  const email = document.getElementById('editUserEmail').value.trim();
  const role = parseInt(document.getElementById('editUserRole').value);
  const token = localStorage.getItem('auth_token');

  fetch(`http://127.0.0.1:8000/api/update/${userId}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    },
    body: JSON.stringify({
      name: name,
      email: email,
      role: role
    })
  })
    .then(response => response.json())
    .then(data => {
      alert("✅ User updated successfully!");
      const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
      modal.hide();
      loadUsers();
    })
    .catch(err => {
      console.error("❌ Update error:", err);
      alert("❌ Failed to update user.");
    });
});

</script>


<script>
document.getElementById('addUserForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const name = document.getElementById('addUserName').value.trim();
  const email = document.getElementById('addUserEmail').value.trim();
  const role = parseInt(document.getElementById('addUserRole').value);
  const password = document.getElementById('addUserPassword').value;
  const token = localStorage.getItem('auth_token');

  fetch('http://127.0.0.1:8000/api/create', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
    },
    body: JSON.stringify({
      name: name,
      email: email,
      role: role,
      password: password
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.message) {
      alert('✅ User added successfully!');
      const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
      modal.hide();
      document.getElementById('addUserForm').reset();
      loadUsers(); // refresh user list
    } else if(data.errors){
      alert('❌ Error: ' + JSON.stringify(data.errors));
    }
  })
  .catch(error => {
    console.error('❌ Add user error:', error);
    alert('❌ Failed to add user.');
  });
});
</script>

<script>
  function deleteUser(userId) {
  if (!confirm("Are you sure you want to delete this user?")) return;

  const token = localStorage.getItem('auth_token');

  fetch(`http://127.0.0.1:8000/api/delete/${userId}`, {
    method: 'DELETE',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    if(data.message === 'User deleted successfully'){
      alert('✅ ' + data.message);
      loadUsers(); // refresh the user list after delete
    } else {
      alert('❌ ' + data.message);
    }
  })
  .catch(error => {
    console.error('❌ Delete user error:', error);
    alert('❌ Failed to delete user.');
  });
}
</script>

<script>
 document.getElementById('searchInput').addEventListener('input', function () {
  const searchValue = this.value.toLowerCase();
  // Piliin lahat ng <tr> sa loob ng <tbody id="usersTable">
  const rows = document.querySelectorAll('#usersTable tr');

  rows.forEach(row => {
    const rowText = row.textContent.toLowerCase();
    if (rowText.includes(searchValue)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
});


</script>