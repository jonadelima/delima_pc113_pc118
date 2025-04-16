<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .settings-card {
            max-width: 450px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
            background-color: white;
        }
        .profile-img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #007bff;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="settings-card text-center">
    <h3 class="mb-4">User Settings</h3>

    <img id="currentImage" src="uploads/default.png" alt="Profile Image" class="profile-img">

    <form id="uploadForm" enctype="multipart/form-data" class="mt-4">
        <div class="mb-3 text-start">
            <label for="profileImage" class="form-label">Upload New Profile Image</label>
            <input type="file" class="form-control" id="profileImage" name="profileImage" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Upload</button>
    </form>

    <a href="dashboard.php" class="btn btn-outline-secondary w-100 mt-3">Back to Dashboard</a>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $('#uploadForm').submit(function (event) {
        event.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: 'upload.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Uploaded!',
                    text: 'Your profile image has been updated.'
                });
                $('#currentImage').attr('src', 'uploads/' + response + '?v=' + new Date().getTime());
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Failed',
                    text: 'Something went wrong while uploading the file.'
                });
            }
        });
    });
</script>

</body>
</html>
