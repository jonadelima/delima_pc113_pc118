<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
  ?>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo-container text-center">
      <p class="admin-text">Assistant</p>
      <hr>
    </div>
    <a href="assistant_dashboard.php" class="<?= $currentPage == 'assistant_dashboard.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-tachometer-alt me-2"></i> Dashboard
    </a>
    <a href="assistanttask.php" class="<?= $currentPage == 'assistanttask.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-users me-2"></i> Task List
    </a>
    <a href="assistantreminders.php" class="<?= $currentPage == 'assistantreminders.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-tasks me-2"></i> Reminders
    </a>
    <a href="assistantsubmission.php" class="<?= $currentPage == 'assistantsubmission.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-user-tie me-2"></i> Submissions
    </a>
    <a href="assistantprofile.php"class="<?= $currentPage == 'assistantprofile.php' ? 'active text-primary fw-bold' : '' ?>">
      <i class="fas fa-chart-line me-2"></i> Profile
    </a>
     <a href="#" id="logoutBtnSidebar" class="<?= $currentPage == '' ? 'active text-primary fw-bold' : '' ?> d-block d-lg-none">
      <i class="fas fa-sign-out-alt me-2 "></i>Logout
    </a>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
    const logoutBtn = document.getElementById('logoutBtnSidebar');
    if (logoutBtn) {
      logoutBtn.addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
          title: 'Are you sure you want to logout?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          cancelButtonText: 'Cancel',
          showClass: {
            popup: `
              animate__animated
              animate__fadeInUp
              animate__faster
            `
          },
          hideClass: {
            popup: `
              animate__animated
              animate__fadeOutDown
              animate__faster
            `
          }
        }).then((result) => {
          if (result.isConfirmed) {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('name');
            window.location.href = 'index.php';
          }
        });
      });
    }
  });
</script>

