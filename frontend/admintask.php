<?php require_once('admin/header.php') ?>
<?php require_once('admin/navbar.php') ?>
<?php require_once('admin/sidebar.php') ?>

  <style>
    body { background-color: #f8f9fa; margin: 0; padding: 0; }

    .sidebar {
      height: 100vh;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
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

    .table-actions button {
      margin-right: 5px;
    }
  </style>

<!-- Top Bar -->
<div class="topbar">
  <h4>Task Management</h4>
</div>

<!-- Content -->
<div class="content">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-card-checklist me-2"></i>Task List</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
      <i class="bi bi-plus-circle"></i> Add Task
    </button>
  </div>

  <table class="table table-bordered table-striped" id="taskTable">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Assigned By</th>
        <th>Due Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- Dynamic rows -->
    </tbody>
  </table>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addTaskForm">
        <div class="modal-header">
          <h5 class="modal-title">Add New Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Task Title</label>
            <input type="text" class="form-control" name="title" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="date" class="form-control" name="due_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Task</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editTaskForm">
        <div class="modal-header">
          <h5 class="modal-title">Edit Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="editTaskId">
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="editTitle" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" id="editDescription" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="date" class="form-control" name="due_date" id="editDueDate" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update Task</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
  const role = localStorage.getItem("role");
  if (!role) {
    window.location.href = "index.php";
  }
  $("#userRole").text(role);

  loadTasks();

  function loadTasks() {
    $.get("http://localhost:8000/api/tasks", function(data) {
      let rows = "";
      data.forEach(task => {
        rows += `
          <tr>
            <td>${task.id}</td>
            <td>${task.title}</td>
            <td>${task.description}</td>
            <td>${task.assigned_by}</td>
            <td>${task.due_date}</td>
            <td class="table-actions">
              <button class="btn btn-warning btn-sm" onclick="editTask(${task.id}, '${task.title}', '${task.description}', '${task.due_date}')">
                <i class="bi bi-pencil"></i>
              </button>
              <button class="btn btn-danger btn-sm" onclick="deleteTask(${task.id})">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>`;
      });
      $("#taskTable tbody").html(rows);
    });
  }

  $("#addTaskForm").submit(function (e) {
    e.preventDefault();
    $.post("http://localhost:8000/api/tasks", $(this).serialize(), function () {
      $("#addTaskModal").modal("hide");
      $("#addTaskForm")[0].reset();
      loadTasks();
    }).fail(function () {
      alert("Error adding task");
    });
  });

  $("#editTaskForm").submit(function (e) {
    e.preventDefault();
    const id = $("#editTaskId").val();
    $.ajax({
      url: `http://localhost:8000/api/tasks/${id}`,
      method: "PUT",
      data: {
        title: $("#editTitle").val(),
        description: $("#editDescription").val(),
        due_date: $("#editDueDate").val()
      },
      success: function () {
        $("#editTaskModal").modal("hide");
        loadTasks();
      },
      error: function () {
        alert("Error updating task");
      }
    });
  });
});

function editTask(id, title, description, due_date) {
  $("#editTaskId").val(id);
  $("#editTitle").val(title);
  $("#editDescription").val(description);
  $("#editDueDate").val(due_date);
  $("#editTaskModal").modal("show");
}

function deleteTask(id) {
  if (confirm("Delete this task?")) {
    $.ajax({
      url: `http://localhost:8000/api/tasks/${id}`,
      type: "DELETE",
      success: function () {
        loadTasks();
      },
      error: function () {
        alert("Failed to delete");
      }
    });
  }
}

</script>




