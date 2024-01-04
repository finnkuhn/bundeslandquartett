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
    <h1>Spiel starten</h1>
    <p>Drücke den Knopf um das Spiel zu starten. Jedem Team werden 5 Bundesland-Karten und 1 Boni-Karte zugeteilt.</p>
    <button class="button-default button-submit" onclick="showConfirmation()">Spiel starten</button>

    <script>
        function showConfirmation() {
            var isConfirmed = confirm("Bist du dir sicher, dass du das Spiel starten willst? Stelle sicher, dass du alle teilnehmenden Teams bereits erstellt hast, da nachträglich keine neuen erstellt werden können.");
            if (isConfirmed) {
                window.location.href = "admin/game_start_process.php";
            }
        }
    </script>
</body>

</html>