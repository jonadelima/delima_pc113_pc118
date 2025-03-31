<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e1b2f;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #2c2340;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }
        .btn-custom {
            background-color: #6f42c1;
            border: none;
        }
        .btn-custom:hover {
            background-color: #5a32a3;
        }
    </style>
</head>
<body>
    <div class="login-container w-25 text-center">
        <h2 class="mb-4">Login</h2>
        <form id="loginform">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Login</button>
        </form>
        <p class="mt-3"><a href="#" class="text-light">Forgot Password?</a></p>
    </div>

    <script>
        document.getElementById("loginform").addEventListener("submit", async function(event) {
            event.preventDefault();
            
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            try {
                const response = await fetch("http://127.0.0.1:8000/api/login", {
                    method: "POST",
                    headers: { 
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();
                console.log("API Response:", data); 
                if (response.ok && data.token) {
                    localStorage.setItem("token", data.token);
                    window.location.href = "dashboard.php"; 
                } else {
                    alert(data.message || "Invalid email or password");
                }
            } catch (error) {
                console.error("Error:", error);
                alert("An error occurred. Please try again later.");
            }
        });
    </script> 
</body>
</html> -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5; 
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #3a3a3a; 
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }
        .login-title {
            color: #ffffff;
        }
        .form-control {
            background-color: #f5f5f5;
            border: none;
            color: #333;
        }
        .form-control::placeholder {
            color: rgba(39, 35, 35, 0.6);
        }
        .btn-custom {
            background-color: #ffffff; 
            border: none;
            color: #333;
            font-weight: bold;
            padding: 10px;
            border-radius: 8px;
            font-size: 1rem;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color:rgb(149, 144, 144);
        }
        .forgot-password {
            color: #cccccc;
            text-decoration: none;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="mb-4 login-title">User Login</h2>
        <form id="loginForm">
            <div class="mb-3">
                <input type="email" class="form-control" id="email" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Login</button>
        </form>
        <p class="mt-3"><a href="#" class="forgot-password">Forgot Password?</a></p>
    </div>

    <script>
    document.getElementById("loginForm").addEventListener("submit", async function(event) {
        event.preventDefault();
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        try {
            const response = await fetch("http://127.0.0.1:8000/api/login", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (response.ok) {
                localStorage.setItem("token", data.token);
                window.location.href = "dashboard.php"; 
            } else {
                alert(data.message || "Invalid email or password");
            }
        } catch (error) {
            console.error("Error:", error);
            alert("An error occurred. Please try again later.");
        }
    });
    </script>
</body>
</html>
