<?php
// Function to establish a database connection
function connectDatabase() {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "bundeslandquartett";

    // Create a new MySQLi object and establish the connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>