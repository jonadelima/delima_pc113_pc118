<?php require_once('teacher/header.php') ?>
<?php require_once('teacher/navbar.php') ?>
<?php require_once('teacher/sidebar.php') ?>

<style>
  body {
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
  }

  .content {
    margin-left: 250px;
    padding: 20px;
  }

  @media (max-width: 767.98px) {
    .content {
      margin-left: 0;
      padding: 15px;
    }
  }
</style>

<div class="content mt-5">
  <div class="container mt-1">
    <div class="card border-0 rounded-4 bg-transparent shadow-sm">
      <div class="card-body p-4">
        <div class="d-flex align-items-center mb-4">
          <i class="fas fa-user-circle fa-3x me-3" style="color: #808080;"></i>
          <div>
            <h3 class="card-title mb-0" style="color: #808080;">User Profile</h3>
            <p class="mb-0" style="color: #808080;">Personal Information</p>
          </div>
        </div>

        <hr class="border-light">

        <!-- Profile Display -->
        <div id="profileInfo" class="row d-flex flex-wrap"></div>

        <!-- Edit Form (hidden by default) -->
        <form id="editForm" class="row g-3" style="display: none;">
          <div class="col-12 col-md-6">
            <label for="editName" class="form-label" style="color: #808080;">Full Name:</label>
            <input type="text" id="editName" class="form-control" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="editEmail" class="form-label" style="color: #808080;">Email:</label>
            <input type="email" id="editEmail" class="form-control" required>
          </div>
          <div class="col-12 mt-3">
            <button type="button" class="btn btn-success me-2" id="saveBtn">Save Changes</button>
            <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
          </div>
        </form>

        <div class="mt-4">
          <button class="btn btn-primary" id="editBtn">Edit Profile</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const token = localStorage.getItem("auth_token");

  const profileInfo = document.getElementById("profileInfo");
  const editForm = document.getElementById("editForm");
  const editBtn = document.getElementById("editBtn");
  const saveBtn = document.getElementById("saveBtn");
  const cancelBtn = document.getElementById("cancelBtn");
  const editName = document.getElementById("editName");
  const editEmail = document.getElementById("editEmail");

  function loadProfile() {
    fetch("http://127.0.0.1:8000/api/profile", {
      method: "GET",
      headers: {
        "Authorization": `Bearer ${token}`,
        "Accept": "application/json"
      }
    })
    .then(response => {
      if (!response.ok) throw new Error("Failed to fetch profile.");
      return response.json();
    })
    .then(data => {
      profileInfo.innerHTML = `
        <div class="col-12 col-md-6 mb-3">
          <strong style="color: #808080;">Full Name:</strong>
          <p style="color: #808080;">${data.name}</p>
        </div>
        <div class="col-12 col-md-6 mb-3">
          <strong style="color: #808080;">Email:</strong>
          <p style="color: #808080;">${data.email}</p>
        </div>
      `;

      // Prefill edit inputs
      editName.value = data.name;
      editEmail.value = data.email;

      // Show profile info, hide edit form by default
      profileInfo.style.display = "flex";
      editForm.style.display = "none";
      editBtn.style.display = "inline-block";
    })
    .catch(error => {
      console.error("Error:", error);
      profileInfo.innerHTML = `<p class='text-danger'>Failed to load profile.</p>`;
    });
  }

  function saveProfile() {
    const updatedName = editName.value.trim();
    const updatedEmail = editEmail.value.trim();

    if (!updatedName || !updatedEmail) {
      alert("Please fill in all fields.");
      return;
    }

    fetch("http://127.0.0.1:8000/api/profile/update", {
      method: "PUT",
      headers: {
        "Authorization": `Bearer ${token}`,
        "Content-Type": "application/json",
        "Accept": "application/json"
      },
      body: JSON.stringify({
        name: updatedName,
        email: updatedEmail
      })
    })
    .then(response => {
      if (!response.ok) throw new Error("Failed to update profile.");
      return response.json();
    })
    .then(data => {
      alert("Profile updated successfully!");
      loadProfile();
    })
    .catch(error => {
      console.error("Error:", error);
      alert("Failed to update profile.");
    });
  }

  // Show edit form
  editBtn.addEventListener("click", () => {
    profileInfo.style.display = "none";
    editForm.style.display = "flex";
    editBtn.style.display = "none";
  });

  // Cancel editing
  cancelBtn.addEventListener("click", () => {
    editForm.style.display = "none";
    profileInfo.style.display = "flex";
    editBtn.style.display = "inline-block";
  });

  // Save changes
  saveBtn.addEventListener("click", saveProfile);

  // Load profile on page load
  loadProfile();
});
</script>
