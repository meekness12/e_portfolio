<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course = $_POST['course'];
    $file = $_FILES['file'];

    // Check for errors
    if ($file['error'] == 0) {
        // Define the directory where the files will be stored
        $targetDir = "uploads/" . $_SESSION['student_id'] . "/" . $course . "/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);  // Create the directory if it doesn't exist
        }

        // Define the target file path
        $targetFile = $targetDir . basename($file["name"]);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            echo "File has been uploaded successfully.";
        } else {
            echo "Error in uploading file.";
        }
    }
}
?>
