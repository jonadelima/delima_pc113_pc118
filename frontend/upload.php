<?php
if ($_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = uniqid() . '_' . basename($_FILES['profileImage']['name']);
    $uploadFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $uploadFile)) {
        echo $fileName;
    } else {
        http_response_code(500);
        echo "Upload failed";
    }
} else {
    http_response_code(400);
    echo "No file uploaded";
}
?>
