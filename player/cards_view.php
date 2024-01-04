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
    <h1>Karten ansehen</h1>

    <!-- Display the cards-main table here -->
    <h2>Deine Bundesland-Karten:</h2>
    <table>
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>Aufgabe</th>
            <th>Bonuspunkte</th>
        </tr>
        <?php while ($rowMain = $resultMain->fetch_assoc()) : ?>
            <?php
            $cardsMainId = $rowMain['cards-main-id'];
            $cardDetails = getCardDetails($conn, $cardsMainId);
            ?>
            <tr>
                <td><?php echo $cardsMainId; ?></td>
                <td><?php echo $cardDetails['name']; ?></td>
                <td><?php echo $cardDetails['text']; ?></td>
                <td><?php echo $cardDetails['points']; ?>p</td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Display the cards-bonus table here -->
    <h2>Deine Boni-Karte:</h2>
    <table>
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>Aufgabe</th>
            <th>Bonuspunkte</th>
            <th>Vetodauer</th>
        </tr>
        <?php while ($rowBonus = $resultBonus->fetch_assoc()) : ?>
            <?php
            $cardsBonusId = $rowBonus['cards-bonus-id'];
            $stmt = $conn->prepare("SELECT `name`, `text`, `points`, `time` FROM `cards-bonus` WHERE `id` = ?");
            $stmt->bind_param("i", $cardsBonusId);
            $stmt->execute();
            $result = $stmt->get_result();
            $cardBonusDetails = $result->fetch_assoc();
            ?>
            <tr>
                <td><?php echo $cardsBonusId; ?></td>
                <td><?php echo $cardBonusDetails['name']; ?></td>
                <td><?php echo $cardBonusDetails['text']; ?></td>
                <td><?php echo $cardBonusDetails['points']; ?>p</td>
                <td><?php echo $cardBonusDetails['time']; ?> Minuten</td>
            </tr>
        <?php endwhile; ?>
    </table>

<?php
// Close the database connection
$conn->close();
?>

</body>

</html>
