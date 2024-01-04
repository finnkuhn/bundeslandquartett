<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start or resume the session
session_start();

// Check if the team ID is set in the session
if (isset($_SESSION["teamId"])) {
    $teamId = $_SESSION["teamId"];

    // Now you have the team ID ($teamId), and you can use it in your PHP code as needed
    // For example, you can use it to fetch the team name from the "teams" table

    // Include the database connection file to get the connection
    include("../connect.inc.php");

    // Get the database connection
    $conn = connectDatabase();
} else {
    // If the team ID is not set in the session, handle the case accordingly
    // For example, you can redirect the user to the login page or display an error message
    header("Location: login.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected state ID from the form
    $selectedStateId = $_POST["selectedState"];

    // Fetch the associated team ID for the selected state
    $stmtTeamForState = $conn->prepare("SELECT `team-id` FROM `events-cards-main` WHERE `states-id` = ?");
    $stmtTeamForState->bind_param("i", $selectedStateId);
    $stmtTeamForState->execute();
    $resultTeamForState = $stmtTeamForState->get_result();
    $teamForStateData = $resultTeamForState->fetch_assoc();
    $teamForStateId = $teamForStateData['team-id'];

    // Fetch a random challenge ID from the "cards-challenge" table
    $stmtRandomChallengeId = $conn->prepare("SELECT id FROM `cards-challenge` ORDER BY RAND() LIMIT 1");
    $stmtRandomChallengeId->execute();
    $resultRandomChallengeId = $stmtRandomChallengeId->get_result();
    $randomChallengeIdData = $resultRandomChallengeId->fetch_assoc();
    $randomChallengeId = $randomChallengeIdData['id'];

    // Insert a new row into "events-cards-challenge"
    $stmtInsertChallenge = $conn->prepare("INSERT INTO `events-cards-challenge` (`team-id-1`, `team-id-2`, `state-id`, `cards-challenge-id`) VALUES (?, ?, ?, ?)");
    $stmtInsertChallenge->bind_param("iiii", $teamId, $teamForStateId, $selectedStateId, $randomChallengeId);
    $stmtInsertChallenge->execute();

    // Redirect back to challenge_center.php
    header("Location: challenge_center.php");
    exit();
}

// Close the database connection
$conn->close();
?>
