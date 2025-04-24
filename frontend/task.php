<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Task Assignment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <style>
    body { background-color: #f8f9fa; }
    .sidebar {
      height: 100vh;
      background: #343a40;
      color: white;
      position: fixed;
      width: 250px;
    }
    .sidebar a { color: white; padding: 15px; display: block; text-decoration: none; }
    .sidebar a:hover { background: #495057; }
    .content { margin-left: 250px; padding: 20px; }
    .topbar {
      background: #ffffff;
      padding: 15px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }
    .topbar .profile { margin-right: 20px; }
  </style>
</head>
<body>

<?php include 'layout.php'; ?>

<div class="mt-4">
  <h2>Task Assignment Management</h2>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Task List</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
      <i class="fas fa-plus"></i> Add Task
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
      <!-- Task rows will load here via JS -->
    </tbody>
  </table>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Task</button>
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
            <textarea class="form-control" name="description" id="editDescription" required></textarea>
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

      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
  loadTasks();

  function loadTasks() {
    $.get("http://localhost:8000/api/tasks", function(data) {
      let taskRows = "";
      data.forEach(task => {
        taskRows += `
          <tr>
            <td>${task.id}</td>
            <td>${task.title}</td>
            <td>${task.description}</td>
            <td>${task.assigned_by}</td>
            <td>${task.due_date}</td>
            <td>
              <button class="btn btn-danger btn-sm" onclick="deleteTask(${task.id})">Delete</button>
              <button class="btn btn-warning btn-sm" onclick="editTask(${task.id}, '${task.title}', '${task.description}', '${task.due_date}')">Edit</button>

            </td>
          </tr>
        `;
      });
      $("#taskTable tbody").html(taskRows);
    });
  }

  $("#addTaskForm").submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: "http://localhost:8000/api/tasks",
      type: "POST",
      data: $(this).serialize(),
      success: function(response) {
        alert("Task added successfully!");
        $("#addTaskModal").modal("hide");
        loadTasks();
        $("#addTaskForm")[0].reset();
      },
      error: function(xhr) {
        alert("Failed to add task: " + xhr.responseText);
      }
    });
  });

  const userRole = localStorage.getItem("role");
  if (!userRole) {
    window.location.href = "index.php";
  }
});

function deleteTask(taskId) {
  if (confirm("Are you sure you want to delete this task?")) {
    $.ajax({
      url: `http://localhost:8000/api/tasks/${taskId}`,
      type: "DELETE",
      success: function(response) {
        alert("Task deleted successfully!");
        loadTasks();
      },
      error: function(xhr) {
        alert("Failed to delete task: " + xhr.responseText);
      }
    });

    function editTask(id, title, description, due_date) {
  $("#editTaskId").val(id);
  $("#editTitle").val(title);
  $("#editDescription").val(description);
  $("#editDueDate").val(due_date);
  $("#editTaskModal").modal("show");
}

$("#editTaskForm").submit(function(e) {
  e.preventDefault();
  const id = $("#editTaskId").val();
  $.ajax({
    url: `http://localhost:8000/api/tasks/${id}`,
    type: "PUT",
    data: {
      title: $("#editTitle").val(),
      description: $("#editDescription").val(),
      due_date: $("#editDueDate").val()
    },
    success: function(response) {
      alert("Task updated successfully!");
      $("#editTaskModal").modal("hide");
      loadTasks();
    },
    error: function(xhr) {
      alert("Failed to update task.");
    }
  });
});

  }
}

function logout() {
  alert("Logging out...");
  window.location.href = "index.php";
}

</script>

</body>
</html>


