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

    // Check if the form has been submitted
    if (isset($_POST["submit"])) {
        // Get the selected card ID and state ID from the form
        $cardsMainId = $_POST["challenge"];
        $stateId = $_POST["state"];

        // Update the events-cards-main table to set "done" to 1 and update "state-id" for the selected card ID and team ID
        $stmtUpdateMain = $conn->prepare("UPDATE `events-cards-main` SET `done` = 1, `states-id` = ? WHERE `team-id` = ? AND `cards-main-id` = ?");
        $stmtUpdateMain->bind_param("iii", $stateId, $teamId, $cardsMainId);
        $stmtUpdateMain->execute();
        $stmtUpdateMain->close();

        // Fetch the points from the cards-main table for the selected card ID
        $stmtPoints = $conn->prepare("SELECT `points` FROM `cards-main` WHERE `id` = ?");
        $stmtPoints->bind_param("i", $cardsMainId);
        $stmtPoints->execute();
        $resultPoints = $stmtPoints->get_result();
        $rowPoints = $resultPoints->fetch_assoc();
        $pointsToAdd = $rowPoints['points'];
        $stmtPoints->close();

        // Fetch the points from the states table for the selected state ID
        $stmtStatePoints = $conn->prepare("SELECT `points` FROM `states` WHERE `id` = ?");
        $stmtStatePoints->bind_param("i", $stateId);
        $stmtStatePoints->execute();
        $resultStatePoints = $stmtStatePoints->get_result();
        $rowStatePoints = $resultStatePoints->fetch_assoc();
        $statePointsToAdd = $rowStatePoints['points'];
        
        $stmtStatePoints->close();// Fetch the current points of the team from the database
        $stmtCurrentPoints = $conn->prepare("SELECT `points` FROM `teams` WHERE `id` = ?");
        $stmtCurrentPoints->bind_param("i", $teamId);
        $stmtCurrentPoints->execute();
        $resultCurrentPoints = $stmtCurrentPoints->get_result();
        $currentPoints = $resultCurrentPoints->fetch_assoc()['points'];
        $stmtCurrentPoints->close();
        
        // Calculate the new total points (existing points + new points to add)
        $newTotalPoints = $currentPoints + $pointsToAdd + $statePointsToAdd;
        
        // Update the teams table with the new total points
        $stmtUpdatePoints = $conn->prepare("UPDATE `teams` SET `points` = ? WHERE `id` = ?");
        $stmtUpdatePoints->bind_param("ii", $newTotalPoints, $teamId);
        $stmtUpdatePoints->execute();
        $stmtUpdatePoints->close();

        // Update the states table to set "locked" to 1 for the selected state ID
        $stmtUpdateState = $conn->prepare("UPDATE `states` SET `locked` = 1 WHERE `id` = ?");
        $stmtUpdateState->bind_param("i", $stateId);
        $stmtUpdateState->execute();
        $stmtUpdateState->close();

        // Generate a random cards-main-id that is not already in events-cards-main
        $randomCardsMainId = generateRandomUniqueCardMainId($conn);
        
        // Insert a new row into events-cards-main table
        $stmtInsertMain = $conn->prepare("INSERT INTO `events-cards-main` (`team-id`, `states-id`, `time`, `done`, `cards-main-id`) VALUES (?, 100, NOW(), 0, ?)");
        $stmtInsertMain->bind_param("ii", $teamId, $randomCardsMainId);
        $stmtInsertMain->execute();
        $stmtInsertMain->close();

        // Display the team and card IDs before redirecting
        echo "Team ID: " . $_SESSION["teamId"] . "<br>";
        echo "Card ID: " . $cardsMainId . "<br>";
        echo "State Points Added: " . $statePointsToAdd . "<br>";

        // Redirect to the desired page after processing the form
        header("Location: cards_main_done.php");
        exit();
    } else {
        // If the form was not submitted, redirect to an error page or display an error message
        header("Location: dashboard.php");
        exit();
    }
} else {
    // If the team ID is not set in the session, handle the case accordingly
    // For example, you can redirect the user to the login page or display an error message
    header("Location: login.php");
    exit();
}

function generateRandomUniqueCardMainId($conn) {
    $availableCardIds = array();

    // Get all distinct "cards-main-id" values from the "cards-main" table
    $resultMain = $conn->query("SELECT DISTINCT id FROM `cards-main`");
    while ($row = $resultMain->fetch_assoc()) {
        $availableCardIds[] = $row['id'];
    }

    // Get all "cards-main-id" values from the "events-cards-main" table
    $resultEventsMain = $conn->query("SELECT `cards-main-id` FROM `events-cards-main`");
    while ($row = $resultEventsMain->fetch_assoc()) {
        $existingCardId = $row['cards-main-id'];
        // Remove existing card IDs from available IDs
        if (($key = array_search($existingCardId, $availableCardIds)) !== false) {
            unset($availableCardIds[$key]);
        }
    }

    // Select a random available card ID
    $randomCardMainId = $availableCardIds[array_rand($availableCardIds)];

    return $randomCardMainId;
}
?>
