<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Task Assignment System | MLG College of Learning</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }
    .navbar-brand img {
      height: 40px;
    }
    .hero-section {
      background: linear-gradient(135deg, #0056b3, #00bfff);
      color: white;
      padding: 200px 0;
      text-align: center;
    }
    .hero-section h1 {
      font-size: 3rem;
      font-weight: 600;
    }
    .hero-section p {
      font-size: 1.2rem;
    }
    .btn-primary, .btn-outline-light {
      padding: 10px 25px;
      font-size: 1rem;
    }
    footer {
      background-color: #343a40;
      color: #aaa;
      padding: 20px 0;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="logo.png" alt="MLG Logo">
      Task Assignment System
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a href="#features" class="nav-link">Features</a></li>
        <li class="nav-item"><a href="index.php" class="nav-link">Login</a></li>
        <li class="nav-item"><a href="register.php" class="nav-link">Register</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero -->
<section class="hero-section">
  <div class="container">
    <h1>Task Assignment System</h1>
    <div class="mt-4">
      <!-- <a href="login.php" class="btn btn-outline-light me-2">Login</a> -->
    </div>
  </div>    
</section>

<!-- Features Section -->
<section id="features" class="py-5 bg-white">
  <div class="container">
    <h2 class="text-center mb-4">System Features</h2>
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <div class="p-4 border rounded shadow-sm">
          <h5>Task Management</h5>
          <p>Create, assign, and update tasks easily for students and assistants.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="p-4 border rounded shadow-sm">
          <h5>Submission Tracking</h5>
          <p>Track submissions, grades, and deadlines through an organized interface.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="p-4 border rounded shadow-sm">
          <h5>Roles & Permissions</h5>
          <p>Secure access for Admin, Teacher, and Assistant Teacher roles.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-center">
  <div class="container">
    <p class="mb-0">© <?= date('Y') ?> MLG College of Learning | Task Assignment System</p>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
