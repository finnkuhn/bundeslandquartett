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

    if (isset($_POST["submit"])) {
        // Get the selected bonus card ID from the form
        $bonusCardId = $_POST["challenge"];

        // Update the events-cards-bonus table to set "done" to 1 for the selected bonus card ID and team ID
        $stmtUpdateBonus = $conn->prepare("UPDATE `events-cards-bonus` SET `done` = 1 WHERE `team-id` = ? AND `cards-bonus-id` = ?");
        $stmtUpdateBonus->bind_param("ii", $teamId, $bonusCardId);
        $stmtUpdateBonus->execute();
        $stmtUpdateBonus->close();

        // Fetch the points from the cards-bonus table for the selected bonus card ID
        $stmtBonusPoints = $conn->prepare("SELECT `points` FROM `cards-bonus` WHERE `id` = ?");
        $stmtBonusPoints->bind_param("i", $bonusCardId);
        $stmtBonusPoints->execute();
        $resultBonusPoints = $stmtBonusPoints->get_result();
        $rowBonusPoints = $resultBonusPoints->fetch_assoc();
        $bonusPointsToAdd = $rowBonusPoints['points'];
        $stmtBonusPoints->close();

        // Update the teams table to increase the points for the team ID
        $stmtUpdatePoints = $conn->prepare("UPDATE `teams` SET `points` = `points` + ? WHERE `id` = ?");
        $stmtUpdatePoints->bind_param("ii", $bonusPointsToAdd, $teamId);
        $stmtUpdatePoints->execute();
        $stmtUpdatePoints->close();

        // Display the team ID and bonus card ID before redirecting
        echo "Team ID: " . $_SESSION["teamId"] . "<br>";
        echo "Bonus Card ID: " . $bonusCardId . "<br>";

        // Check if there are any remaining unused bonus cards for the team
        $stmtUnusedBonus = $conn->prepare("SELECT `id` FROM `cards-bonus` WHERE `id` NOT IN (SELECT `cards-bonus-id` FROM `events-cards-bonus` WHERE `team-id` = ?)");
        $stmtUnusedBonus->bind_param("i", $teamId);
        $stmtUnusedBonus->execute();
        $resultUnusedBonus = $stmtUnusedBonus->get_result();

        // If there are unused bonus cards, randomly select one and insert a new row in events-cards-bonus
        if ($resultUnusedBonus->num_rows > 0) {
            $unusedBonusIds = [];
            while ($row = $resultUnusedBonus->fetch_assoc()) {
                $unusedBonusIds[] = $row['id'];
            }
            
            $randomUnusedBonusId = $unusedBonusIds[array_rand($unusedBonusIds)];
            
            $stmtInsertBonus = $conn->prepare("INSERT INTO `events-cards-bonus` (`team-id`, `done`, `cards-bonus-id`) VALUES (?, 0, ?)");
            $stmtInsertBonus->bind_param("ii", $teamId, $randomUnusedBonusId);
            $stmtInsertBonus->execute();
            $stmtInsertBonus->close();
        }
        else {
            // Check if there are any bonus cards for the team
            $usedstmtBonus = $conn->prepare("SELECT `id` FROM `cards-bonus`");
            $usedstmtBonus->execute();
            $resultBonus = $usedstmtBonus->get_result();

            $BonusIds = [];
            while ($row = $resultBonus->fetch_assoc()) {
                $BonusIds[] = $row['id'];
            }
            
            $randomBonusId = $BonusIds[array_rand($BonusIds)]; // Corrected this line
            
            $stmtInsertBonus = $conn->prepare("INSERT INTO `events-cards-bonus` (`team-id`, `done`, `cards-bonus-id`) VALUES (?, 0, ?)");
            $stmtInsertBonus->bind_param("ii", $teamId, $randomBonusId);
            $stmtInsertBonus->execute();
            $stmtInsertBonus->close();
        }

        // Redirect to the desired page after processing the form
        header("Location: cards_bonus_done.php");
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
?>
