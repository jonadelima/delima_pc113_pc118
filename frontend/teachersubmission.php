<?php require_once('teacher/header.php') ?>
<?php require_once('teacher/navbar.php') ?>
<?php require_once('teacher/sidebar.php') ?>



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

  <div class="card p-3 mb-4">
    <div class="row g-2 align-items-center">
      <div class="col-md-5 col-sm-12">
        <form id="importForm" class="d-flex flex-wrap gap-2" enctype="multipart/form-data">
          <input id="file" type="file" name="file" accept=".csv,.xls,.xlsx" class="form-control form-control-sm" required>
          <button type="submit" class="btn btn-success btn-sm">Import</button>
        </form>
      </div>
      <div class="col-md-7 col-sm-12 d-flex flex-wrap justify-content-md-end gap-2 mt-2 mt-md-0">
        <a href="http://localhost:8000/api/students/export" class="btn btn-primary btn-sm">Export</a>
        <button onclick="window.print()" class="btn btn-secondary btn-sm">Print</button>
      </div>
    </div>
  </div>

  <div class="card shadow p-4">
    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Student ID</th>
            <th>Name</th>
            <th>Course</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="student-table-body">
          <!-- JavaScript populates here -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  // Import Handler
  document.getElementById('importForm').addEventListener('submit', function (e) {
    e.preventDefault();
    let file = document.getElementById('file').files[0];
    const formData = new FormData();
    formData.append('file', file)

    fetch('http://localhost:8000/api/students/import', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + localStorage.getItem('token') // Assuming you store the token in localStorage
      },
      body: formData,
      processData: false,
      contentType: false
    })
    .then(res => res.json())
    .then(data => {
      console.log(data);
      alert(data.message);
      // loadStudents();
    })
    .catch(error => {
      console.error('Import failed:', error);
      alert('Import failed!');
    });
  });

  // Load Students
  function loadStudents() {
    fetch('http://localhost:8000/api/students')
      .then(res => res.json())
      .then(data => {
        const tbody = document.getElementById('student-table-body');
        tbody.innerHTML = '';

        data.forEach((student, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${index + 1}</td>
            <td>${student.student_id}</td>
            <td>${student.name}</td>
            <td>${student.course}</td>
            <td>${student.status}</td>
          `;
          tbody.appendChild(row);
        });
      })
      .catch(err => {
        console.error('Failed to load students', err);
      });
  }

  // Initial Load
  loadStudents();
</script>
