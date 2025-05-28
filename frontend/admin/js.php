<script>
  document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('auth_token');

    if (!token) {
      window.location.href = 'index.php';
    }

    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
      logoutBtn.addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
          title: 'Are you sure?',
          text: "You are going to log out.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          cancelButtonText: 'Cancel',
        }).then((result) => {
          if (result.isConfirmed) {
            fetch('http://127.0.0.1:8000/api/logout', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token,
              }
            })
            .then(async response => {
              const data = await response.json();
              if (response.ok) {
                localStorage.removeItem('auth_token');
                Swal.fire({
                  title: 'Logged out!',
                  text: data.message,
                  icon: 'success',
                }).then(() => {
                  window.location.href = 'index.php';
                });
              } else {
                Swal.fire({
                  title: 'Error!',
                  text: data.message || 'Logout failed. Please try again.',
                  icon: 'error',
                });
              }
            })
            .catch(error => {
              Swal.fire({
                title: 'Error!',
                text: 'An error occurred. Please try again.',
                icon: 'error',
              });
            });
          }
        });
      });
    }
  });
</script>
