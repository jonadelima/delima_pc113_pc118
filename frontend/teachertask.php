<?php require_once('teacher/header.php'); ?>
<?php require_once('teacher/navbar.php'); ?>
<?php require_once('teacher/sidebar.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Task Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body { background-color: #f8f9fa; }
    .content { padding: 20px; }
    .topbar {
      background-color: #fff;
      padding: 15px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    @media (min-width: 768px) {
      .content { margin-left: 250px; }
      .topbar { margin-left: 250px; }
    }
  </style>
</head>
<body>

<div class="content container-fluid">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-card-checklist me-2"></i>Task List</h2>
    <button class="btn btn-primary mt-2 mt-md-0" data-bs-toggle="modal" data-bs-target="#addTaskModal">
      <i class="bi bi-plus-circle"></i> Add Task
    </button>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-striped" id="taskTable">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Description</th>
          <th>Subject</th>
          <th>Type</th>
          <th>Assigned To</th>
          <th>Due Date</th>
          <th>File</th>
          <th>QR Code</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="addTaskForm" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>
          <textarea name="description" class="form-control mb-2" placeholder="Description" required></textarea>
          <input type="text" name="subject" class="form-control mb-2" placeholder="Subject" required>
          <input type="text" name="type" class="form-control mb-2" placeholder="Type" required>
          <input type="text" name="assigned_to" class="form-control mb-2" placeholder="Assigned To" required>
          <input type="date" name="due_date" class="form-control mb-2" required>
          <input type="file" name="file" class="form-control mb-2">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editTaskForm" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editTaskId" name="id">
          <input type="text" name="title" id="editTitle" class="form-control mb-2" required>
          <textarea name="description" id="editDescription" class="form-control mb-2" required></textarea>
          <input type="text" name="subject" id="editSubject" class="form-control mb-2" required>
          <input type="text" name="type" id="editType" class="form-control mb-2" required>
          <input type="text" name="assigned_to" id="editAssignedTo" class="form-control mb-2" required>
          <input type="date" name="due_date" id="editDueDate" class="form-control mb-2" required>
          <input type="file" name="file" class="form-control mb-2">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- View Task Modal -->
<div class="modal fade" id="viewTaskModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Task Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Title:</strong> <span id="viewTitle"></span></p>
        <p><strong>Description:</strong> <span id="viewDescription"></span></p>
        <p><strong>Subject:</strong> <span id="viewSubject"></span></p>
        <p><strong>Type:</strong> <span id="viewType"></span></p>
        <p><strong>Assigned To:</strong> <span id="viewAssignedTo"></span></p>
        <p><strong>Due Date:</strong> <span id="viewDueDate"></span></p>
        <p><strong>File:</strong> <span id="viewFile"></span></p>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    loadTasks();

    document.getElementById("addTaskForm").addEventListener("submit", async function (e) {
      e.preventDefault();
      const form = e.target;
      const formData = new FormData(form);

      try {
        const response = await fetch("http://localhost:8000/api/tasks", {
          method: "POST",
          body: formData,
        });

        const result = await response.json();
        if (!response.ok) throw new Error(result.message || "Failed to add task.");

        Swal.fire("Success", result.message || "Task added successfully", "success");
        bootstrap.Modal.getInstance(document.getElementById("addTaskModal")).hide();
        form.reset();
        loadTasks();
      } catch (error) {
        Swal.fire("Error", error.message, "error");
      }
    });

    document.getElementById("editTaskForm").addEventListener("submit", async function (e) {
      e.preventDefault();
      const form = e.target;
      const formData = new FormData(form);
      const taskId = document.getElementById("editTaskId").value;
      formData.append("_method", "PUT");

      try {
        const response = await fetch(`http://localhost:8000/api/tasks/${taskId}`, {
          method: "POST",
          body: formData,
        });

        const result = await response.json();
        if (!response.ok) throw new Error(result.message || "Failed to update task.");

        Swal.fire("Updated", result.message || "Task updated successfully", "success");
        bootstrap.Modal.getInstance(document.getElementById("editTaskModal")).hide();
        form.reset();
        loadTasks();
      } catch (error) {
        Swal.fire("Error", error.message, "error");
      }
    });
  });

  async function loadTasks() {
    try {
      const response = await fetch("http://localhost:8000/api/tasks");
      if (!response.ok) throw new Error("Failed to load tasks");

      const tasks = await response.json();
      const tbody = document.querySelector("#taskTable tbody");
      tbody.innerHTML = "";

      tasks.forEach(task => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${task.id}</td>
          <td>${task.title}</td>
          <td>${task.description}</td>
          <td>${task.subject}</td>
          <td>${task.type}</td>
          <td>${task.assigned_to}</td>
          <td>${task.due_date}</td>
          <td>${task.file ? `<a href="http://localhost:8000/storage/${task.file}" target="_blank">View</a>` : "N/A"}</td>
          <td><canvas id="qr-${task.id}"></canvas></td>
          <td>
            <button class="btn btn-sm btn-info me-1" onclick='viewTask(${JSON.stringify(task)})'>View</button>
            <button class="btn btn-sm btn-success me-1" onclick='fillEditForm(${JSON.stringify(task)})'>Edit</button>
            <button class="btn btn-sm btn-danger" onclick='deleteTask(${task.id})'>Delete</button>
          </td>
        `;
        tbody.appendChild(row);

        new QRious({
          element: document.getElementById(`qr-${task.id}`),
          value: `Task: ${task.title}\nSubject: ${task.subject}\nDue: ${task.due_date}`,
          size: 60
        });
      });

    } catch (error) {
      Swal.fire("Error", error.message, "error");
    }
  }

  function fillEditForm(task) {
    document.getElementById("editTaskId").value = task.id;
    document.getElementById("editTitle").value = task.title;
    document.getElementById("editDescription").value = task.description;
    document.getElementById("editSubject").value = task.subject;
    document.getElementById("editType").value = task.type;
    document.getElementById("editAssignedTo").value = task.assigned_to;
    document.getElementById("editDueDate").value = task.due_date;
    bootstrap.Modal.getOrCreateInstance(document.getElementById("editTaskModal")).show();
  }

  async function deleteTask(id) {
    const confirm = await Swal.fire({
      title: "Are you sure?",
      text: "This will delete the task permanently.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!"
    });

    if (!confirm.isConfirmed) return;

    try {
      const response = await fetch(`http://localhost:8000/api/tasks/${id}`, {
        method: "DELETE"
      });

      const result = await response.json();
      if (!response.ok) throw new Error(result.message || "Failed to delete task.");

      Swal.fire("Deleted", result.message || "Task deleted successfully", "success");
      loadTasks();
    } catch (error) {
      Swal.fire("Error", error.message, "error");
    }
  }

  function viewTask(task) {
    document.getElementById("viewTitle").innerText = task.title;
    document.getElementById("viewDescription").innerText = task.description;
    document.getElementById("viewSubject").innerText = task.subject;
    document.getElementById("viewType").innerText = task.type;
    document.getElementById("viewAssignedTo").innerText = task.assigned_to;
    document.getElementById("viewDueDate").innerText = task.due_date;
    document.getElementById("viewFile").innerHTML = task.file ? `<a href="http://localhost:8000/storage/${task.file}" target="_blank">View File</a>` : "N/A";
    bootstrap.Modal.getOrCreateInstance(document.getElementById("viewTaskModal")).show();
  }
</script>
</body>
</html>
    