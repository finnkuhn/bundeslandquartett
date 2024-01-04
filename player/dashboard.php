<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Spieler - Bundeslandquartett</title>
    <link rel="stylesheet" type="text/css" charset="utf-8" href="../css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
    <h1>Übersicht</h1>
    <?php
    // Start or resume the session
    session_start();

    // Check if the team ID is set in the session
    if (isset($_SESSION["teamId"])) {
        $teamId = $_SESSION["teamId"];

        // Include the database connection file to get the connection
        include("../connect.inc.php");

        // Get the database connection
        $conn = connectDatabase();

        // Fetch the team's points from the teams table
        $stmt = $conn->prepare("SELECT `points` FROM `teams` WHERE `id` = ?");
        $stmt->bind_param("i", $teamId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $teamPoints = $row['points'];
        $stmt->close();

        // Display the team's points
        echo "<p>Aktuelle Punktzahl: " . $teamPoints . "</p>";

        // Close the database connection
        $conn->close();
    }
    ?>
    <list>
        <li><a href="cards_view.php">Karten ansehen</a></li>
        <li><a href="cards_main_done.php">Bundesland-Karten abschließen</a></li>
        <li><a href="cards_bonus_done.php">Boni-karten abschließen</a></li>
        <li><a href="challenge_center.php">Challenge Center</a></li>
    </list>
</body>
</html>
