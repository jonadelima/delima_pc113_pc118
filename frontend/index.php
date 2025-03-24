<!DOCTYPE html>
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
        <form id="loginform"> <!-- ✅ Added ID -->
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
                console.log("API Response:", data); // ✅ Debugging line

                if (response.ok && data.token) {
                    localStorage.setItem("token", data.token);
                    window.location.href = "dashboard.php"; // ✅ Redirect to dashboard
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
