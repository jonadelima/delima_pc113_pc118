<?php require_once('teacher/header.php'); ?>
<?php require_once('teacher/navbar.php'); ?>
<?php require_once('teacher/sidebar.php'); ?>

<style>
  body { background-color: #f8f9fa; margin: 0; padding: 0; }
  .content { margin-left: 250px; padding: 20px; }
  .topbar {
    background-color: #fff;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-left: 250px;
  }
</style>

<div class="topbar">
  <h4>Task Management</h4>
</div>

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
        <th>Subject</th>
        <th>Type</th>
        <th>Assigned To</th>
        <th>Due Date</th>
        <th>File</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addTaskForm" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Add New Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="assigned_by" value="1">
          <div class="mb-3">
            <label class="form-label">Task Title</label>
            <input type="text" class="form-control" name="title" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" class="form-control" name="subject" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Type</label>
            <select class="form-control" name="type" required>
              <option value="homework">Homework</option>
              <option value="project">Project</option>
              <option value="quiz">Quiz</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Assign To (User IDs)</label>
            <input type="text" class="form-control" name="assigned_to" placeholder="e.g. 2,3" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="date" class="form-control" name="due_date" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Upload File</label>
            <input type="file" class="form-control" name="file">
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
      <form id="editTaskForm" enctype="multipart/form-data">
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
            <label class="form-label">Subject</label>
            <input type="text" class="form-control" name="subject" id="editSubject" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Type</label>
            <select class="form-control" name="type" id="editType" required>
              <option value="homework">Homework</option>
              <option value="project">Project</option>
              <option value="quiz">Quiz</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Assigned To</label>
            <input type="text" class="form-control" name="assigned_to" id="editAssignedTo" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="date" class="form-control" name="due_date" id="editDueDate" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Upload File (optional)</label>
            <input type="file" class="form-control" name="file">
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

      if (!response.ok) {
        const error = await response.json();
        alert(error.message || "Failed to add task.");
        return;
      }

      const result = await response.json();
      alert(result.message || "Task added successfully");
      bootstrap.Modal.getInstance(document.getElementById("addTaskModal")).hide();
      form.reset();
      loadTasks();
    } catch (error) {
      console.error("Add Error:", error);
      alert("Something went wrong while adding the task.");
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

      if (!response.ok) {
        const error = await response.json();
        alert(error.message || "Failed to update task.");
        return;
      }

      const result = await response.json();
      alert(result.message || "Task updated successfully");
      bootstrap.Modal.getInstance(document.getElementById("editTaskModal")).hide();
      form.reset();
      loadTasks();
    } catch (error) {
      console.error("Edit Error:", error);
      alert("Something went wrong while updating the task.");
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
        <td>${task.subject}</td>
        <td>${task.type}</td>
        <td>${task.assigned_to}</td>
        <td>${task.due_date}</td>
        <td>${task.file ? `<a href="http://localhost:8000/storage/${task.file}" target="_blank">View</a>` : "N/A"}</td>
        <td>
          <button class="btn btn-sm btn-success" onclick='fillEditForm(${JSON.stringify(task)})'>Edit</button>
        </td>
      `;
      tbody.appendChild(row);
    });

  } catch (error) {
    console.error("Load Error:", error);
    alert("Error loading tasks.");
  }
}

function fillEditForm(task) {
  document.getElementById("editTaskId").value = task.id;
  document.getElementById("editTitle").value = task.title;
  document.getElementById("editSubject").value = task.subject;
  document.getElementById("editType").value = task.type;
  document.getElementById("editAssignedTo").value = task.assigned_to;
  document.getElementById("editDueDate").value = task.due_date;
  bootstrap.Modal.getOrCreateInstance(document.getElementById("editTaskModal")).show();
}
</script>
