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

    // Function to fetch card details from "cards-main" table by cards-main-id
    function getCardDetails($conn, $cardsMainId) {
        $stmt = $conn->prepare("SELECT `name`, `text`, `points` FROM `cards-main` WHERE `id` = ?");
        $stmt->bind_param("i", $cardsMainId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cardDetails = $result->fetch_assoc();
        $stmt->close();

        return $cardDetails;
    }

    // Fetch card details from "events-cards-main" with done == 0 for the team
    $stmtMain = $conn->prepare("SELECT `cards-main-id` FROM `events-cards-main` WHERE `team-id` = ? AND `done` = 0");
    $stmtMain->bind_param("i", $teamId);
    $stmtMain->execute();
    $resultMain = $stmtMain->get_result();

    // Fetch card details from "events-cards-bonus" with done == 0 for the team
    $stmtBonus = $conn->prepare("SELECT `cards-bonus-id` FROM `events-cards-bonus` WHERE `team-id` = ? AND `done` = 0");
    $stmtBonus->bind_param("i", $teamId);
    $stmtBonus->execute();
    $resultBonus = $stmtBonus->get_result();

    // Fetch all main challenges
    $stmtChallenges = $conn->prepare("SELECT DISTINCT `name` FROM `cards-main`");
    $stmtChallenges->execute();
    $resultChallenges = $stmtChallenges->get_result();
} else {
    // If the team ID is not set in the session, handle the case accordingly
    // For example, you can redirect the user to the login page or display an error message
    header("Location: login.php");
    exit();
}

// Fetch all states with locked = 0
$stmtStates = $conn->prepare("SELECT `id`, `name` FROM `states` WHERE `locked` = 0");
$stmtStates->execute();
$resultStates = $stmtStates->get_result();
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
    <h1>Bundesland-Karten abschließen</h1>

    <!-- Form to select a main challenge -->
    <form class="form-default" action="cards_main_done_process.php" method="post" onsubmit="return confirmSelection();">
        <label for="challenge">Wähle eine deiner Bundesland-Karten aus</label>
        <select name="challenge" id="challenge">
            <?php while ($rowMain = $resultMain->fetch_assoc()) : ?>
                <?php
                $cardsMainId = $rowMain['cards-main-id'];
                $cardDetails = getCardDetails($conn, $cardsMainId);
                ?>
                <option value="<?php echo $cardsMainId; ?>"><?php echo $cardDetails['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <!-- Add another dropdown select for states -->
        <label for="state">Wähle ein Bundesland aus</label>
        <select name="state" id="state">
            <?php while ($rowState = $resultStates->fetch_assoc()) : ?>
                <option value="<?php echo $rowState['id']; ?>"><?php echo $rowState['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <input class="button-default button-submit" type="submit" name="submit" value="Karte abschließen">
    </form>

    <script>
        function confirmSelection() {
            const selectedCardId = document.getElementById("challenge").value;
            const selectedCardName = document.getElementById("challenge").options[document.getElementById("challenge").selectedIndex].text;

            // Get the selected state name from the state dropdown
            const selectedState = document.getElementById("state").value;

            // Display a confirmation dialog with both card and state information
            const isConfirmed = confirm("Du hast die Bundesland-Karte mit der id " + selectedCardId + " und dem Namen '" + selectedCardName + "' für das Bundesland '" + selectedState + "' ausgewählt. Bist du sicher, dass du dieses Bundesland mit dieser Karte abschließen möchtest?");

            // Return true if the user confirmed, otherwise return false to prevent form submission
            return isConfirmed;
        }
    </script>

    <?php
    // Close the database connection
    $conn->close();
    ?>

</body>

</html>
