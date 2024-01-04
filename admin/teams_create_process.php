<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database configuration file to get the connection
include ("../connect.inc.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $teamName = $_POST["name"];
    $teamPassword = $_POST["password"];

    // Hash the password using PHP's password_hash function
    $hashedPassword = password_hash($teamPassword, PASSWORD_DEFAULT);

    // Establish the database connection using the function from db_config.php
    $conn = connectDatabase();

    // Prepare and execute the SQL query to insert the team into the database
    $stmt = $conn->prepare("INSERT INTO teams (name, points, password) VALUES (?, 0, ?)");
    $stmt->bind_param("ss", $teamName, $hashedPassword);
    $stmt->execute();

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();

    // Redirect back to the form page or show a success message
    header("Location: teams_create.php");
    exit();
}
?>
