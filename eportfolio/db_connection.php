<?php
$servername = "localhost"; // Change if needed
$username = "root"; // Your DB username
$password = ""; // Your DB password
$database = "e_portfolio"; // Your database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>