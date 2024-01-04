<?php
// Include the database configuration file to get the connection
include("../connect.inc.php");

// Function to start the game
function startGame($conn) {
    // Prepare the SQL query to insert rows into "events-cards-main" table
    $stmtMain = $conn->prepare('INSERT INTO `events-cards-main` (`team-id`, `states-id`, `done`, `cards-main-id`) VALUES (?, 100, 0, ?)');

    // Prepare the SQL query to insert rows into "events-cards-bonus" table
    $stmtBonus = $conn->prepare('INSERT INTO `events-cards-bonus` (`team-id`, `done`, `cards-bonus-id`) VALUES (?, 0, ?)');

    if (!$stmtMain || !$stmtBonus) {
        // Display an error message and exit if the statement preparation fails
        die("Error in preparing the SQL query: " . $conn->error);
    }

    // Get all distinct "cards-main-id" values from the "cards-main" table
    $cardsMainIds = array();
    $resultMain = $conn->query("SELECT DISTINCT id FROM `cards-main`");
    while ($row = $resultMain->fetch_assoc()) {
        $cardsMainIds[] = $row['id'];
    }

    // Get all "cards-bonus-id" values from the "cards-bonus" table
    $cardsBonusIds = array();
    $resultBonus = $conn->query("SELECT id FROM `cards-bonus`");
    while ($row = $resultBonus->fetch_assoc()) {
        $cardsBonusIds[] = $row['id'];
    }

    // Get the number of teams from the "teams" table
    $resultTeams = $conn->query("SELECT id FROM teams");
    while ($row = $resultTeams->fetch_assoc()) {
        $teamId = $row['id'];

        // Shuffle the "cards-main-id" array to get random values for the current team
        shuffle($cardsMainIds);

        // Add 5 different "cards-main-id" for the current "team-id"
        for ($i = 0; $i < 5; $i++) {
            $cardsMainId = array_shift($cardsMainIds);
            $stmtMain->bind_param("ii", $teamId, $cardsMainId);
            $stmtMain->execute();
        }

        // Pick a random "cards-bonus-id" for the current "team-id"
        $randomBonusId = $cardsBonusIds[array_rand($cardsBonusIds)];
        $stmtBonus->bind_param("ii", $teamId, $randomBonusId);
        $stmtBonus->execute();
    }

    // Close the statements
    $stmtMain->close();
    $stmtBonus->close();
}

// Establish the database connection using the function from connect.inc.php
$conn = connectDatabase();

// Start the game and insert rows into the "events-cards-main" and "events-cards-bonus" tables
startGame($conn);

// Close the database connection
$conn->close();

// Redirect back to the game start page or show a success message
header("Location: game_start.php");
exit();
?>
