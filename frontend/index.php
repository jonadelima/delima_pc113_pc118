<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px; 
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .signup-link {
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-container">
        <h3 class="text-center mb-4">Login</h3>
        
        <!-- Alert Message -->
        <div id="alertBox" class="alert alert-danger d-none" role="alert"></div>

        <form id="loginForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" id="email" class="form-control" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" class="form-control" placeholder="Enter password" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>

        <!-- Signup Link -->
        <div class="signup-link">
            <p>Don't have any account? <a href="register.php">Signup</a></p>
        </div>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const alertBox = document.getElementById('alertBox');

    fetch('http://127.0.0.1:8000/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ email: email, password: password })
    })
    .then(response => response.json().then(data => ({ status: response.status, ok: response.ok, body: data })))
    .then(result => {
        const data = result.body;

        if (result.ok) {
            localStorage.setItem('auth_token', data.token);
            localStorage.setItem('user_role', data.role);

            const role = parseInt(data.role);
            alertBox.classList.remove('d-none', 'alert-danger');
            alertBox.classList.add('alert-success');
            alertBox.innerHTML = data.message;

            setTimeout(() => {
                if (role === 0) {
                    window.location.href = 'admindashboard.php';
                } else if (role === 1) {
                    window.location.href = 'teacher_dashboard.php';
                } else if (role === 2) {
                    window.location.href = 'assistant_dashboard.php';
                } else {
                    alertBox.classList.remove('alert-success');
                    alertBox.classList.add('alert-danger');
                    alertBox.innerHTML = `Unknown role: ${role}`;
                }
            }, 1000);
        } else {
            alertBox.classList.remove('d-none', 'alert-success');
            alertBox.classList.add('alert-danger');
            alertBox.innerHTML = data.message;
        }
    })
    .catch(error => {
        alertBox.classList.remove('d-none', 'alert-success');
        alertBox.classList.add('alert-danger');
        alertBox.innerHTML = `Error: ${error.message}`;
    });
});
</script>


</body>
</html>
   