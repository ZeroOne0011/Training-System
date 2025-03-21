<?php
// db.php
$host = 'localhost';
$dbname = 'training_system';
$user = 'root';
$pass = '';

// Create a new database connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
