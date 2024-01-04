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

    // Fetch records from "events-cards-main" where "done" is 1 and "team-id" is not the current team
    $stmtDoneCards = $conn->prepare("SELECT `team-id`, `states-id` FROM `events-cards-main` WHERE `done` = 1 AND `team-id` <> ?");
    $stmtDoneCards->bind_param("i", $teamId);
    $stmtDoneCards->execute();
    $resultDoneCards = $stmtDoneCards->get_result();
} else {
    // If the team ID is not set in the session, handle the case accordingly
    // For example, you can redirect the user to the login page or display an error message
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8" />
    <title>Spieler - Bundeslandquartett</title>
    <link rel="stylesheet" type="text/css" charset="utf-8" href="../css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>
    <h1>Challenge Center</h1>
    <h2>Übersicht laufender Challenges</h2>
    <table>
        <thead>
            <tr>
                <th>Bundesland</th>
                <th>Gegnerisches Team</th>
                <th>Startzeit</th>
                <th>Herausforderung</th>
                <th>Text</th>
                <th>Zeit</th>
                <th>Endzeit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch rows from "events-cards-challenge" where $teamId is either in "team-id-1" or "team-id-2"
            $stmtChallenges = $conn->prepare("SELECT * FROM `events-cards-challenge` WHERE (`team-id-1` = ? OR `team-id-2` = ?) AND `done` = 0");
            $stmtChallenges->bind_param("ii", $teamId, $teamId);
            $stmtChallenges->execute();
            $resultChallenges = $stmtChallenges->get_result();

            while ($rowChallenge = $resultChallenges->fetch_assoc()) {
                $stateId = $rowChallenge['state-id'];
                $challengeId = $rowChallenge['cards-challenge-id'];
                $time = $rowChallenge['time'];

                // Determine the opponent's team ID
                $opponentTeamId = ($rowChallenge['team-id-1'] !== $teamId) ? $rowChallenge['team-id-1'] : $rowChallenge['team-id-2'];

                // Fetch state name
                $stmtStateName = $conn->prepare("SELECT `name` FROM `states` WHERE `id` = ?");
                $stmtStateName->bind_param("i", $stateId);
                $stmtStateName->execute();
                $resultStateName = $stmtStateName->get_result();
                $stateName = $resultStateName->fetch_assoc()['name'];

                // Fetch opponent team name
                $stmtOpponentTeam = $conn->prepare("SELECT `name` FROM `teams` WHERE `id` = ?");
                $stmtOpponentTeam->bind_param("i", $opponentTeamId);
                $stmtOpponentTeam->execute();
                $resultOpponentTeam = $stmtOpponentTeam->get_result();
                $opponentTeamName = $resultOpponentTeam->fetch_assoc()['name'];

                $startTime = strtotime($time . ' +1 hour');

                // Fetch challenge details from cards-challenge table
                $stmtChallengeDetails = $conn->prepare("SELECT `name`, `text`, `time` FROM `cards-challenge` WHERE `id` = ?");
                $stmtChallengeDetails->bind_param("i", $challengeId);
                $stmtChallengeDetails->execute();
                $resultChallengeDetails = $stmtChallengeDetails->get_result();
                $challengeDetails = $resultChallengeDetails->fetch_assoc();
                $challengeName = $challengeDetails['name'];
                $challengeText = $challengeDetails['text'];
                $challengeTime = $challengeDetails['time'];

                $endTime = strtotime($time . ' +1 hour +' . $challengeTime . ' minutes');
                $currentTime = time();

                $formattedStartTime = date('H:i', $startTime);
                $formattedEndTime = date('H:i', $endTime);

                // Display additional columns if the current time is after start time
                if ($currentTime >= $startTime) {
                    echo '<tr>';
                    echo '<td>' . $stateName . '</td>';
                    echo '<td>' . $opponentTeamName . '</td>';
                    echo '<td>' . $formattedStartTime . '</td>';
                    echo '<td>' . $challengeName . '</td>';
                    echo '<td>' . $challengeText . '</td>';
                    echo '<td>' . $challengeTime . ' Minuten</td>';
                    echo '<td>' . $formattedEndTime . '</td>';
                    echo '</tr>';
                }
                else {
                    echo '<tr>';
                    echo '<td>' . $stateName . '</td>';
                    echo '<td>' . $opponentTeamName . '</td>';
                    echo '<td>' . $formattedStartTime . '</td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>

    <h2>Neue Challenge</h2>
    <?php
    // Fetch all states where "locked" is 1 and the "state-id" does not appear in the events-cards-challenge table
    $stmtStates = $conn->prepare("SELECT `id`, `name` FROM `states` WHERE `locked` = 1 AND `id` NOT IN (SELECT DISTINCT `state-id` FROM `events-cards-challenge`)");
    $stmtStates->execute();
    $resultStates = $stmtStates->get_result();
    ?>

    <form class="form-default" action="challenge_center_new_process.php" method="post">
        <label for="selectedState">Wähle ein Bundesland aus</label>
        <select name="selectedState" id="selectedState">
            <?php while ($rowState = $resultStates->fetch_assoc()) : ?>
                <?php
                // Fetch the associated team name for the state
                $stateId = $rowState['id'];
                $stmtTeamForState = $conn->prepare("SELECT `team-id` FROM `events-cards-main` WHERE `states-id` = ?");
                $stmtTeamForState->bind_param("i", $stateId);
                $stmtTeamForState->execute();
                $resultTeamForState = $stmtTeamForState->get_result();
                $teamForStateData = $resultTeamForState->fetch_assoc();
                $teamForStateId = $teamForStateData['team-id'];

                // Fetch the team name
                $stmtOtherTeam = $conn->prepare("SELECT `name` FROM `teams` WHERE `id` = ?");
                $stmtOtherTeam->bind_param("i", $teamForStateId);
                $stmtOtherTeam->execute();
                $resultOtherTeam = $stmtOtherTeam->get_result();
                $otherTeamData = $resultOtherTeam->fetch_assoc();
                $otherTeamName = $otherTeamData['name'];
                ?>

                <option value="<?php echo $stateId; ?>">
                    <?php echo $rowState['name'] . ' (' . $otherTeamName . ')'; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <input type="submit" class="button-default button-submit" name="submit" value="Bundesland challengen">
    </form>

    <h2>Challenge abschließen</h2>
    <form class="form-default" action="challenge_center_done_process.php" method="post">
        <label for="completedChallenge">Wähle eine Challenge aus</label>
        <select name="completedChallenge" id="completedChallenge">
            <?php
            // Fetch rows from "events-cards-challenge" where $teamId is in "team-id-1"
            $stmtCompletedChallenges = $conn->prepare("SELECT `id`, `state-id` FROM `events-cards-challenge` WHERE `team-id-1` = ? AND `done` = 0");
            $stmtCompletedChallenges->bind_param("i", $teamId);
            $stmtCompletedChallenges->execute();
            $resultCompletedChallenges = $stmtCompletedChallenges->get_result();

            while ($rowCompletedChallenge = $resultCompletedChallenges->fetch_assoc()) {
                $stateId = $rowCompletedChallenge['state-id'];

                // Fetch state name from states table
                $stmtStateName = $conn->prepare("SELECT `id`, `name` FROM `states` WHERE `id` = ?");
                $stmtStateName->bind_param("i", $stateId);
                $stmtStateName->execute();
                $resultStateName = $stmtStateName->get_result();
                $stateName = $resultStateName->fetch_assoc()['name'];

                echo '<option value="' . $rowCompletedChallenge['id'] . '">' . $stateName . '</option>';
            }
            ?>
        </select>
        <input type="submit" class="button-default button-submit" name="submit" value="Challenge gewonnen">
    </form>

    <h2>Challenge beenden</h2>
    <form class="form-default" action="challenge_center_failed_process.php" method="post">
        <label for="completedChallenge">Wähle eine Challenge aus</label>
        <select name="completedChallenge" id="completedChallenge">
            <?php
            // Fetch rows from "events-cards-challenge" where $teamId is in "team-id-1"
            $stmtCompletedChallenges = $conn->prepare("SELECT `id`, `state-id` FROM `events-cards-challenge` WHERE `team-id-1` = ? AND `done` = 0");
            $stmtCompletedChallenges->bind_param("i", $teamId);
            $stmtCompletedChallenges->execute();
            $resultCompletedChallenges = $stmtCompletedChallenges->get_result();

            while ($rowCompletedChallenge = $resultCompletedChallenges->fetch_assoc()) {
                $stateId = $rowCompletedChallenge['state-id'];

                // Fetch state name from states table
                $stmtStateName = $conn->prepare("SELECT `id`, `name` FROM `states` WHERE `id` = ?");
                $stmtStateName->bind_param("i", $stateId);
                $stmtStateName->execute();
                $resultStateName = $stmtStateName->get_result();
                $stateName = $resultStateName->fetch_assoc()['name'];

                echo '<option value="' . $rowCompletedChallenge['id'] . '">' . $stateName . '</option>';
            }
            ?>
        </select>
        <input type="submit" class="button-default button-delete" name="submit" value="Challenge verloren">
    </form>

    <?php
    // Close the database connection
    $conn->close();
    ?>

</body>
</html>
