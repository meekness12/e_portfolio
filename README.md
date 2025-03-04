# ePortfolio - Rwanda Polytechnic

## Overview

**ePortfolio** is a digital platform designed to replace the traditional physical portfolios used by students at Rwanda Polytechnic. This system allows students to store their academic evidence, such as assignments, projects, and graded materials, in a centralized, secure, and easily accessible digital repository. Instructors can manage student portfolios, assign grades, provide feedback, and upload course materials.

This system will simplify the management of student portfolios, improve efficiency, and enhance security by eliminating the need for physical storage.

---

## Features

- **Student Registration & Management**: Students can register and manage their profiles and portfolios.
- **Course Management**: Instructors can view, manage, and assign students to courses.
- **Evidence Collection**: Students can submit academic evidence for grading and feedback.
- **Feedback & Grading**: Instructors can provide feedback and assign grades to students.
- **Secure Digital Storage**: All student documents and evidence are stored securely in a centralized digital repository.
- **Responsive Design**: The system is designed to be mobile-friendly and accessible on different devices.

---

## Technologies Used

- **Frontend**:
  - HTML5, CSS3, JavaScript (for dynamic interactions)
  - Bootstrap (for responsive design)
- **Backend**:
  - PHP (for server-side logic)
  - MySQL (for database management)
- **Others**:
  - AJAX (for asynchronous operations)
  - Session management in PHP for secure login and user authentication

---

## Project Structure

- `index.php`: Main page to access the system
- `login.php`: Login page for users (students/instructors)
- `dashboard.php`: Dashboard page for instructors
- `manage_students.php`: Page to manage students for instructors
- `db_connection.php`: Handles database connection
- `add_student.php`: Form to add students to a course
- `edit_student.php`: Form to edit student details
- `delete_student.php`: Handles student deletion
- `manage_courses.php`: Manage courses assigned to instructors
- `feedback.php`: Page for instructors to provide feedback to students
- `view_portfolios.php`: Page for viewing students’ portfolios
- `analytics.php`: Analytics page for instructors to view student performance

---

## Installation

### Prerequisites

- **PHP** (7.4 or later)
- **MySQL** (5.7 or later)
- A web server like **Apache** or **Nginx**

### Steps to Install

1. Clone the repository:
   ```bash
   git clone https://github.com/meekness12/e_Portfolio.git
