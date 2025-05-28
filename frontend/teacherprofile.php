<?php require_once('teacher/header.php') ?>
<?php require_once('teacher/navbar.php') ?>
<?php require_once('teacher/sidebar.php') ?>

<style>
      body { background-color: #f8f9fa; margin: 0; padding: 0; }
     .content {
      margin-left: 250px;
      padding: 20px;
    }
</style>
<div class="content mt-5">
  <div class="container mt-1">
    <div class="card border-0 rounded-4 bg-transparent">
      <div class="card-body p-3">
        <div class="d-flex align-items-center mb-4">
          <div class="me-3">
          <i class="fas fa-user-circle fa-3x" style="color: #808080;"></i>
          </div>
          <div>
            <h3 class="card-title mb-0" style="color: #808080;">User Profile</h3>
            <p class=" mb-0" style="color: #808080;">Personal Information</p>
          </div>
        </div>

        <hr class="border-light">

        <div id="profileInfo" class="row">
         
        </div>

  
        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>

      </div>
    </div>
  </div>
</div>

<script>
 document.addEventListener("DOMContentLoaded", function () {
  fetch("http://127.0.0.1:8000/api/profile", {
    method: "GET",
    headers: {
      "Authorization": `Bearer ${localStorage.getItem("auth_token")}`,
      "Accept": "application/json"
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error("Failed to fetch user profile.");
    }
    return response.json();
  })
  .then(data => {
    const container = document.getElementById("profileInfo");

    const profileHTML = `
      <div class="col-md-3 mb-4">
        <strong style="color: #808080;">Full Name:</strong>
        <p style="color: #808080;">${data.name}</p>
      </div>
      <div class="col-md-3 mb-3">
        <strong style="color: #808080;">Email:</strong>
        <p style="color: #808080;">${data.email}</p>
      </div>
    `;

    container.innerHTML = profileHTML;
  })
  .catch(error => {
    console.error("Error:", error);
    document.getElementById("profileInfo").innerHTML = "<p class='text-danger'>Failed to load profile information.</p>";
  });
});

</script>
