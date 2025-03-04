<?php
session_start();
include 'db_connection.php'; // Ensure your DB connection is properly set

// Check if the user is logged in and is an instructor
if (!isset($_SESSION['userid']) || (isset($_SESSION['role']) && $_SESSION['role'] !== 'Instructor')) {
    header("Location: login.php"); // Redirect to login page if not logged in or not an instructor
    exit();
}

// Fetch lecturer information from the session
$lecturer_name = $_SESSION['username'];
$lecturer_id = $_SESSION['userid'];  // Assuming 'userid' is used as lecturer_id

// Fetch courses taught by this lecturer
$sql = "SELECT c.coursename, c.coursecode 
        FROM course_lect cl
        INNER JOIN course c ON cl.coursecode = c.coursecode
        WHERE cl.lecturecode = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $lecturer_id);
$stmt->execute();
$courses_result = $stmt->get_result();

$students_sql = "SELECT s.firstname, s.email, c.coursename AS course_name 
                 FROM student s
                 INNER JOIN class cl ON s.classcode = cl.classcode
                 INNER JOIN course_class cc ON cl.classcode = cc.classcode
                 INNER JOIN course c ON cc.coursecode = c.coursecode
                 INNER JOIN course_lect clt ON c.coursecode = clt.coursecode
                 WHERE clt.lecturecode = ?";

$students_stmt = $conn->prepare($students_sql);
$students_stmt->bind_param("i", $lecturer_id);  // Bind the lecturer's ID to the query
$students_stmt->execute();
$students_result = $students_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Dashboard - ePortfolio</title>
    <link rel="stylesheet" href="lectures.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="top-right-menu">
            <div class="profile-icon">
                <img src="profile.jpg" alt="Profile Picture">
                <span><?php echo htmlspecialchars($lecturer_name); ?></span>
            </div>
            <div class="notifications">
                <i class="fas fa-bell"></i>
                <span class="notification-count">3</span>
            </div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </header>

    <div class="main-container">
        <nav class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Rwanda Polytechnic Logo">
                <span>ePortfolio Lecturer</span>
            </div>
            <ul>
                <li><a href="#dashboard" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#manage-courses"><i class="fas fa-book"></i> Manage Courses</a></li>
                <li><a href="manage_students.php"><i class="fas fa-users"></i> Manage Students</a></li>
                <li><a href="#assign-grades"><i class="fas fa-edit"></i> Assign Grades</a></li>
                <li><a href="#feedback"><i class="fas fa-comment-alt"></i> Provide Feedback</a></li>
                <li><a href="#upload-material"><i class="fas fa-file-upload"></i> Upload Material</a></li>
                <li><a href="#view-portfolio"><i class="fas fa-archive"></i> View Portfolios</a></li>
                <li><a href="#analytics"><i class="fas fa-chart-line"></i> Analytics</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <section id="dashboard" class="admin-section">
                <h1>Welcome, <?php echo htmlspecialchars($lecturer_name); ?></h1>
                <p>Manage your courses, students, grades, and feedback here.</p>
            </section>
</body>
</html>

    <footer>
        <p>&copy; 2025 Rwanda Polytechnic - All Rights Reserved</p>
    </footer>
</body>
</html>