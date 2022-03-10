<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Profil</title>
    <link rel="stylesheet" href="profile.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

    <h1 id="username">
        <?php
            session_start();
            echo $_SESSION["username"];
        ?>
    </h1>
        
    <div id="content">

        <div id="history">
            <h2>Historique</h2>
        </div>

        <div id="game">

            <div id="create-game" action="/action_page.php">
                <h2>Créer une partie</h2>
                <form id="create-game-form" action="/action_page.php">
                    <div>
                        <label for="room-name">Nom de la salle :</label>
                        <input type="text" name="room-name">
                    </div>
                    <input type="submit" value="Créer">
                </form>
            </div>

            <div id="join-game">
                <h2>Rejoindre une partie</h2>
                <div id="rooms-list">
                    <?php
                        $json_string = file_get_contents('data/rooms.json');
                        $rooms = json_decode($json_string, true);

                        foreach ($rooms as $room) {
                            echo "<div class='room'>";
                            echo "<a class='room-name' href='game.php?room=" . $room["name"] . "'>" . $room["name"] . "</a>";
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>

        </div>

    </div>

</body>
</html>