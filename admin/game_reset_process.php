<?php
// Include the database configuration file to get the connection
include ("../connect.inc.php");

// Function to reset the game
function resetGame($conn) {
    // Delete all teams from the 'teams' table
    $conn->query("DELETE FROM teams");

    // Delete all events from the 'events-cards-main', 'events-cards-bonus', and 'events-cards-challenge' tables
    $conn->query("DELETE FROM `events-cards-main`");
    $conn->query("DELETE FROM `events-cards-bonus`");
    $conn->query("DELETE FROM `events-cards-challenge`");

    // Update the 'locked' column in the 'states' table for all rows to 0
    $conn->query("UPDATE states SET locked = 0");
}

// Establish the database connection using the function from connect.inc.php
$conn = connectDatabase();

// Reset the game
resetGame($conn);

// Close the database connection
$conn->close();

// Redirect back to the game reset page
header("Location: game_reset.php");
exit();
?>
