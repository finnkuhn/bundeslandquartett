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
    <h1>Spiel zurücksetzen</h1>
    <p>Drücke den Knopf um das Spiel zurückzusetzen. Alle bestehenden Teams, geclaimten Bundesländer und alle Events werden aus der Datenbank gelöscht.</p>
    <button class="button-default button-delete" onclick="showConfirmation()">Spiel zurücksetzen</button>

    <script>
        function showConfirmation() {
            var isConfirmed = confirm("Bist du dir sicher, dass du das Spiel zurücksetzen willst? Diese Aktion kann NICHT rückgängig gemacht werden.");
            if (isConfirmed) {
                window.location.href = "admin/game_reset_process.php";
            }
        }
    </script>
</body>

</html>