<?php
session_start();
include 'db_connection.php'; // Ensure database connection is set up

// Check if user is logged in and is an instructor
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'Instructor') {
    header("Location: login.php");
    exit();
}

// Fetch lecturer information
$lecturer_name = $_SESSION['username'];
$lecturer_id = $_SESSION['userid'];

// Prepare the SQL query to fetch courses assigned to the lecturer
$courses_sql = "SELECT c.coursecode, c.coursename, cc.classcode 
                FROM course_lect cl
                INNER JOIN course c ON cl.coursecode = c.coursecode
                INNER JOIN course_class cc ON c.coursecode = cc.coursecode
                WHERE cl.lecturecode = ?";

// Prepare statement
$courses_stmt = $conn->prepare($courses_sql);
if ($courses_stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

$courses_stmt->bind_param("i", $lecturer_id);
$courses_stmt->execute();
$courses_result = $courses_stmt->get_result();

// Check if query returned any results
if ($courses_result === false) {
    die('MySQL error: ' . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Course - ePortfolio</title>
    <link rel="stylesheet" href="manage_students.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="top-right-menu">
            <div class="profile-icon">
                <img src="profile.jpg" alt="Profile Picture">
                <span><?php echo $lecturer_name; ?></span>
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
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="manage_courses.php"><i class="fas fa-book"></i> Manage Courses</a></li>
                <li><a href="manage_students.php" class="active"><i class="fas fa-users"></i> Manage Students</a></li>
                <li><a href="assign_grades.php"><i class="fas fa-edit"></i> Assign Grades</a></li>
                <li><a href="feedback.php"><i class="fas fa-comment-alt"></i> Provide Feedback</a></li>
                <li><a href="upload_material.php"><i class="fas fa-file-upload"></i> Upload Material</a></li>
                <li><a href="view_portfolios.php"><i class="fas fa-archive"></i> View Portfolios</a></li>
                <li><a href="analytics.php"><i class="fas fa-chart-line"></i> Analytics</a></li>
            </ul>
        </nav>
        
        <div class="main-content">
            <h2>Select Course to Manage Students</h2>
            <form action="manage_students.php" method="GET">
                <label for="course">Select Course:</label>
                <select name="coursecode" id="course" required>
                    <option value="">Select a Course</option>
                    <?php 
                    // Check if the result set has rows and then display courses
                    if ($courses_result->num_rows > 0) {
                        while ($course = $courses_result->fetch_assoc()) {
                            echo "<option value='" . $course['coursecode'] . "' data-classcode='" . $course['classcode'] . "'>" . $course['coursename'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No courses available</option>";
                    }
                    ?>
                </select>
                <button type="submit">Select Course</button>
            </form>

            <?php
            // If a course is selected, fetch students associated with that course and class
            if (isset($_GET['coursecode']) && !empty($_GET['coursecode'])) {
                $coursecode = $_GET['coursecode'];

                // Fetch students associated with the selected course and class
                $students_sql = "SELECT s.regno, s.firstname, s.email 
                                 FROM student s
                                 INNER JOIN course_class cc ON s.classcode = cc.classcode
                                 WHERE cc.coursecode = ?";
                $students_stmt = $conn->prepare($students_sql);
                if ($students_stmt === false) {
                    die('MySQL prepare error: ' . $conn->error);
                }

                $students_stmt->bind_param("i", $coursecode);
                $students_stmt->execute();
                $students_result = $students_stmt->get_result();

                // Check if student results are fetched
                if ($students_result === false) {
                    die('MySQL error: ' . $conn->error);
                }
                ?>
                <h3>Manage Students in the Selected Course</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($students_result->num_rows > 0) {
                            while ($student = $students_result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $student['firstname']; ?></td>
                                    <td><?php echo $student['email']; ?></td>
                                    <td>
                                        <a href="edit_student.php?regno=<?php echo $student['regno']; ?>">Edit</a> |
                                        <a href="delete_student.php?regno=<?php echo $student['regno']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='3'>No students found in this course.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Form to Add Student -->
                <h3>Add Student to Course</h3>
                <form action="add_student.php" method="POST">
                    <input type="text" name="firstname" placeholder="First Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="hidden" name="coursecode" value="<?php echo $coursecode; ?>">
                    <button type="submit">Add Student</button>
                </form>
                <?php
            }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Rwanda Polytechnic - All Rights Reserved</p>
    </footer>
</body>
</html>
