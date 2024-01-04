<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8" />
    <title>Admin - Bundeslandquartett</title>
    <link rel="stylesheet" type="text/css" charset="utf-8" href="../css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script>
        // Push a state into the history stack when the page loads
        window.onload = function() {
            history.pushState({}, "", "../");
        };
    </script>
</head>

<body>
    <h1>Teams erstellen</h1>
    <form class="form-default" action="admin/teams_create_process.php" method="post">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
        <label for="password">Passwort</label>
        <input type="password" id="password" name="password" required>
        <input class="button-default button-submit" type="submit" value="Add Team">
    </form>
</body>

</html>