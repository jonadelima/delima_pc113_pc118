<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }
    .register-container {
      max-width: 500px;
      margin: 80px auto;
      padding: 30px;
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="container">
  <div class="register-container">
    <h3 class="text-center mb-4">Register</h3>

    <!-- Alert Box -->
    <div id="message" class="alert d-none" role="alert"></div>

    <form id="registerForm">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="Enter full name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Enter email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
      </div>
      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-success">Register</button>
      </div>
    </form>

    <p class="mt-3 text-center">
      Already have an account? <a href="index.php">Login here</a>
    </p>
  </div>
</div>

<!-- Register Script -->
<script>
document.getElementById('registerForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const formData = new FormData();
  formData.append('name', document.getElementById('name').value);
  formData.append('email', document.getElementById('email').value);
  formData.append('password', document.getElementById('password').value);
  formData.append('password_confirmation', document.getElementById('password_confirmation').value);

  const messageBox = document.getElementById('message');

  fetch('http://127.0.0.1:8000/api/register', {
    method: 'POST',
    headers: {
      'Accept': 'application/json'
    },
    body: formData
  })
  .then(response => response.json().then(result => ({ ok: response.ok, body: result })))
  .then(result => {
    const data = result.body;

    if (result.ok) {
      messageBox.className = "alert alert-success";
      messageBox.innerHTML = data.message;
      messageBox.classList.remove('d-none');

      setTimeout(() => {
        window.location.href = "index.php";
      }, 1000);
    } else {
      let errorMessages = '';
      for (let key in data.errors) {
        errorMessages += data.errors[key].join('<br>') + '<br>';
      }
      messageBox.className = "alert alert-danger";
      messageBox.innerHTML = errorMessages;
      messageBox.classList.remove('d-none');
    }
  })
  .catch(error => {
    messageBox.className = "alert alert-danger";
    messageBox.innerHTML = `Error: ${error.message}`;
    messageBox.classList.remove('d-none');
  });
});
</script>

</body>
</html>