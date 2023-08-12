<?php
// MySQL database credentials
$host = "localhost";
$username = "root";
$password = ""; // No password
$database = "Forme";

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
