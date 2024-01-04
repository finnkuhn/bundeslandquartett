<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start or resume the session
session_start();

// Check if the team ID is set in the session
if (isset($_SESSION["teamId"])) {
    $teamId = $_SESSION["teamId"];

    // Include the database connection file to get the connection
    include("../connect.inc.php");

    // Get the database connection
    $conn = connectDatabase();

    // Check if the completed challenge ID is set in the POST data
    if (isset($_POST["completedChallenge"])) {
        $completedChallengeId = $_POST["completedChallenge"];

        // Fetch challenge data from events-cards-challenge
        $stmtChallengeData = $conn->prepare("SELECT `state-id`, `team-id-1`, `team-id-2` FROM `events-cards-challenge` WHERE `id` = ?");
        $stmtChallengeData->bind_param("i", $completedChallengeId);
        $stmtChallengeData->execute();
        $resultChallengeData = $stmtChallengeData->get_result();
        $challengeData = $resultChallengeData->fetch_assoc();
        $stateId = $challengeData['state-id'];
        $teamId1 = $challengeData['team-id-1'];
        $teamId2 = $challengeData['team-id-2'];

        // Update the "locked" column in the states table
        $stmtUpdateState = $conn->prepare("UPDATE `states` SET `locked` = 2 WHERE `id` = ?");
        $stmtUpdateState->bind_param("i", $stateId);
        $stmtUpdateState->execute();
        $stmtUpdateState->close();

        // Fetch state points from states table
        $stmtStatePoints = $conn->prepare("SELECT `points` FROM `states` WHERE `id` = ?");
        $stmtStatePoints->bind_param("i", $stateId);
        $stmtStatePoints->execute();
        $resultStatePoints = $stmtStatePoints->get_result();
        $statePoints = $resultStatePoints->fetch_assoc()['points'];
        $stmtStatePoints->close();

        // Calculate points to be added/subtracted based on team ID
        $pointsChange = ($teamId1 === $teamId) ? $statePoints : -$statePoints;

        // Update points for the current team in teams table
        $stmtUpdateTeamPoints = $conn->prepare("UPDATE `teams` SET `points` = `points` + ? WHERE `id` = ?");
        $stmtUpdateTeamPoints->bind_param("ii", $pointsChange, $teamId);
        $stmtUpdateTeamPoints->execute();
        $stmtUpdateTeamPoints->close();

        // Update points for the other team in teams table
        $otherTeamId = ($teamId1 === $teamId) ? $teamId2 : $teamId1;
        $stmtUpdateOtherTeamPoints = $conn->prepare("UPDATE `teams` SET `points` = `points` - ? WHERE `id` = ?");
        $stmtUpdateOtherTeamPoints->bind_param("ii", $pointsChange, $otherTeamId);
        $stmtUpdateOtherTeamPoints->execute();
        $stmtUpdateOtherTeamPoints->close();

        // Update the "done" column in the events-cards-challenge table
        $stmtUpdateChallenge = $conn->prepare("UPDATE `events-cards-challenge` SET `done` = 1 WHERE `id` = ?");
        $stmtUpdateChallenge->bind_param("i", $completedChallengeId);
        $stmtUpdateChallenge->execute();
        $stmtUpdateChallenge->close();

        // Close the prepared statement
        $stmtChallengeData->close();

        // Redirect back to the challenge center page
        header("Location: challenge_center.php");
        exit();
    }
} else {
    // If the team ID is not set in the session, handle the case accordingly
    // For example, you can redirect the user to the login page or display an error message
    header("Location: login.php");
    exit();
}

// Close the database connection
$conn->close();
?>

