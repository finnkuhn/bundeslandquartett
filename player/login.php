<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Spieler - Bundeslandquartett</title>
    <link rel="stylesheet" type="text/css" charset="utf-8" href="../css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
    <h1>Anmelden</h1>
    <form class="form-default" action="login_process.php" method="post">
        <label for="teamName">Team Name</label>
        <input type="text" id="teamName" name="teamName" required>
        <label for="teamPassword">Passwort</label>
        <input type="password" id="teamPassword" name="teamPassword" required>
        <input class="button-default button-submit" type="submit" value="Login">
    </form>
</body>
</html>
