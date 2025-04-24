<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Task Assignment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #4e73df, #224abe);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .signup-container {
            max-width: 450px;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2);
            text-align: center;
        }
        .logo {
            font-size: 2rem;
            font-weight: bold;
            color: #4e73df;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #4e73df;
            border: none;
        }
        .btn-primary:hover {
            background-color: #3c5bdc;
        }
        p a {
            color: #4e73df;
            text-decoration: none;
        }
        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="signup-container">
        <!-- Logo and Title -->
        <div class="logo mb-4">Task Assignment System</div>
        <h4 class="mb-4">Create an Account</h4>

        <!-- Sign Up Form -->
        <form id="signupForm">
            <input type="text" id="name" class="form-control" placeholder="Full Name" required>
            <input type="email" id="email" class="form-control" placeholder="Email Address" required>
            <input type="password" id="password" class="form-control" placeholder="Password" required>
            <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm Password" required>

            <button type="submit" class="btn btn-primary w-100 mt-2">Sign Up</button>
        </form>

        <!-- Already have an account -->
        <p class="mt-3">Already have an account? <a href="index.php">Login here</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle form submission
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return;
            }

            // API call to Laravel backend
            fetch('http://127.0.0.1:8000/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name, email, password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Account created successfully!");
                    window.location.href = "login.php";
                } else {
                    alert("Failed to register: " + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Something went wrong!");
            });
        });
    </script>

</body>
</html>
