<?php
session_start();
include 'db_connection.php';

// Check if user is logged in and is an instructor
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Instructor') {
    header("Location: login.php");
    exit();
}

// Handle form submission for adding a student
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $coursecode = $_POST['coursecode']; // The selected course code

    // Fetch the class code associated with the course
    $class_sql = "SELECT classcode FROM course_class WHERE coursecode = ?";
    $class_stmt = $conn->prepare($class_sql);
    $class_stmt->bind_param("i", $coursecode);
    $class_stmt->execute();
    $class_result = $class_stmt->get_result();
    $class = $class_result->fetch_assoc();
    $classcode = $class['classcode'];

    // Insert student into the database
    $insert_sql = "INSERT INTO student (firstname, email, classcode) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("ssi", $firstname, $email, $classcode);
    
    if ($stmt->execute()) {
        header("Location: manage_students.php?coursecode=" . $coursecode); // Redirect back to manage students for the same course
    } else {
        echo "Error adding student.";
    }
}
?>
