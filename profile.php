<?php
    session_start();
    if (!isset($_SESSION["username"]) || !isset($_SESSION["id"])) {
        header("Location: index.php");
        exit;
    }

    $rooms = json_decode(file_get_contents('data/rooms.json'), true);
    $modes = json_decode(file_get_contents('data/modes.json'), true);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Profil</title>
    <link rel="stylesheet" href="profile.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

    <h1 id="username"><?php echo $_SESSION["username"]; ?></h1>
        
    <div id="content">

        <div id="history">
            <h2>Historique</h2>
        </div>

        <span class="vsep"></span>

        <div id="game">

            <form id="create-game" action="/create_game.php">
                <h2>Créer une partie</h2>
                <table>
                    <tr>
                        <td><label for="game-mode">Mode de jeu :</label></td>
                        <td><input type="text" name="game-mode" required></td>
                    </tr>
                    <tr>
                        <td><label for="room-name">Nom de la salle :</label></td>
                        <td><input type="text" name="room-name" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;"><input type="submit" value="Créer"></td>
                    </tr>
                </table>
            </form>

            <span class="hsep"></span>

            <div id="join-game">
                <h2>Rejoindre une partie</h2>
                <div id="room-list">
                    <?php
                        foreach ($rooms as $room) {
                            echo "<div class='room clickable'>";
                            echo    "<img class='icon' src='data/icons/" . $room["mode"] . ".png'>";
                            echo    "<span class='name'>" . $room["name"] . "</span>";
                            echo    "<span class='players'>" . $room["players"] . " / " . $modes[$room["mode"]]["limit"] . "</span>";
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>

        </div>

    </div>

</body>
</html>