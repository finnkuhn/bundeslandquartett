<?php
// Include the database configuration file to get the connection
include ("../connect.inc.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $teamName = $_POST["teamName"];
    $teamPassword = $_POST["teamPassword"];

    // Establish the database connection using the function from connect.inc.php
    $conn = connectDatabase();

    // Prepare and execute the SQL query to fetch the team from the database
    $stmt = $conn->prepare("SELECT id, password FROM teams WHERE name = ?");
    $stmt->bind_param("s", $teamName);
    $stmt->execute();
    $stmt->bind_result($teamId, $hashedPassword);

    if ($stmt->fetch()) {
        // Verify the password using the password_verify function
        if (password_verify($teamPassword, $hashedPassword)) {
            // Password is correct, store the team ID in a session and redirect to a dashboard or other page
            session_start();
            $_SESSION["teamId"] = $teamId;
            header("Location: dashboard.php"); // Replace 'dashboard.php' with the desired page after login
            exit();
        } else {
            // Incorrect password, show an error message or redirect back to the login page with an error
            header("Location: login.php?error=1"); // Redirect back to the login page with an error parameter
            exit();
        }
    } else {
        // Team not found, show an error message or redirect back to the login page with an error
        header("Location: login.php?error=1"); // Redirect back to the login page with an error parameter
        exit();
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>
