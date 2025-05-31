<?php require_once('admin/header.php') ?>
<?php require_once('admin/navbar.php') ?>
<?php require_once('admin/sidebar.php') ?>
<style>
  body {
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
  }

  .content {
    margin-left: 250px;
    padding: 20px;
  }

  @media (max-width: 768px) {
    .content {
      margin-left: 0;
      padding: 15px;
    }
  }

  /* PRINT ONLY: Hide everything except the table */
  @media print {
    body * {
      visibility: hidden;
    }

    .content .card.shadow {
      visibility: visible;
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
    }

    .content .card.shadow table {
      width: 100%;
    }

    .content .card.shadow,
    .content .card.shadow * {
      visibility: visible;
    }

    /* Optional: remove borders and colors for cleaner print */
    table, th, td {
      border: 1px solid black !important;
      color: black !important;
    }

    thead.table-dark {
      background-color: #ccc !important;
      color: black !important;
    }
  }
</style>

<div class="content mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Student Submissions</h2>
  </div>

  <!-- Import, Export, and Print Controls -->
  <div class="card p-3 mb-4">
    <div class="row g-2 align-items-center">
      <div class="col-md-5 col-sm-12">
        <form id="importForm" action="http://localhost:8000/api/students/import" method="POST" enctype="multipart/form-data" target="hiddenFrame" class="d-flex flex-wrap gap-2">
        </form>
      </div>
      <div class="col-md-7 col-sm-12 d-flex flex-wrap justify-content-md-end gap-2 mt-2 mt-md-0">
      </div>
    </div>
  </div>

  <!-- Hidden iframe for import -->
  <iframe name="hiddenFrame" style="display:none;"></iframe>

  <!-- Student Submission Table -->
  <div class="card shadow p-4">
    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0">
        <thead class="table-dark">
  <tr>
    <th>#</th>
    <th>Student ID</th>
    <th>Name</th>
    <th>Course</th>
    <th>Status</th> <!-- NEW -->
  </tr>
</thead>

        <tbody id="student-table-body">
          <!-- JavaScript will populate this -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- JavaScript to fetch student data -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    fetchStudents();

    // Re-fetch after importing
    document.getElementById('importForm').addEventListener('submit', function () {
      setTimeout(fetchStudents, 1000); // slight delay to wait for server
    });
  });

  function fetchStudents() {
    fetch('http://localhost:8000/api/students')
      .then(response => response.json())
      .then(data => {
        const tbody = document.getElementById('student-table-body');
        tbody.innerHTML = '';

        if (data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="4" class="text-center">No students found.</td></tr>';
          return;
        }

        data.forEach((student, index) => {
  const row = `
    <tr>
      <td>${index + 1}</td>
      <td>${student.student_id}</td>
      <td>${student.name}</td>
      <td>${student.course}</td>
      <td>${student.status}</td> <!-- NEW -->
    </tr>
  `;
  tbody.innerHTML += row;
});

      })
      .catch(error => {
        console.error('Fetch error:', error);
        const tbody = document.getElementById('student-table-body');
        tbody.innerHTML = '<tr><td colspan="4" class="text-danger text-center">Failed to load student data.</td></tr>';
      });
  }
</script>
