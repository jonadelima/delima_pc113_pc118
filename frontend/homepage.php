<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Assignment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .hero-section {
            padding: 100px 0;
            text-align: center;
            background: linear-gradient(to right, #4e73df, #1cc88a);
            color: white;
        }
        .logo {
            font-size: 3rem;
            font-weight: bold;
        }
        .hero-buttons .btn {
            margin: 10px;
        }
        .hero-logo-img {
            width: 120px;
            height: 120px;
            object-fit: contain;
        }
    </style>
</head>
<body>

    <!-- Header / Hero Section -->
    <div class="hero-section">
        <!-- Logo Image -->
        <img src="assets/logo.png" alt="Task Assignment System Logo" class="logo.jpg">

        <!-- System Name -->
        <div class="logo">Task Assignment System</div>

        <p class="lead mt-3">Efficiently assign, manage, and track tasks for teachers and students.</p>

        <div class="hero-buttons">
        <a href="index.php" class="btn btn-light btn-lg">Login</a>
        <a href="signup.php" class="btn btn-outline-light btn-lg">Sign Up</a>
        </div>
    </div>

    <!-- About Section -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">About the System</h2>
        <p class="text-center">The Task Assignment System is a simple, user-friendly platform that helps teachers and assistant teachers manage task assignments, track student submissions, and receive notifications efficiently. It integrates seamlessly with submission tracking systems for streamlined workflow.</p>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5 py-4 bg-light">
        &copy; <?php echo date("Y"); ?> Task Assignment System. All Rights Reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
