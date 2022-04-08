<?php
    
    include_once "files.php";

    session_start();
    if (!isset($_SESSION["username"]) || !isset($_SESSION["id"])) {
        header("Location: index.php");
        exit;
    }

    $rooms_file = open_file('data/rooms.json');
    $rooms = get_file_content($rooms_file);
    $modes = json_decode(file_get_contents('data/modes.json'), true);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Profil</title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="profile.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<?php
    if (isset($_GET["deja_utilise"])) {
        echo "<script>window.onload = () => alert('Nom déjà utilisé');</script>";
    }
    if (isset($_GET["nom_invalide"])) {
        echo "<script>window.onload = () => alert('Nom invalide');</script>";
    }
?>

    <div id="topbar">
        <a class="clickable" id="disconnect" href="index.php?deconnecte">Se déconnecter</a>
        <h1 id="username"><?php echo $_SESSION["username"]; ?></h1>
    </div>
        
    <div id="content">

        <div id="history">
            <h2>Historique</h2>
        </div>

        <span class="vsep"></span>

        <div id="game">

            <form id="create-room" action="create_room.php">
                <h2>Créer une partie</h2>
                <table>
                    <tr>
                        <td><label for="game-mode">Mode de jeu :</label></td>
                        <td><select name="game-mode" required>
                            <?php
                                foreach ($modes as $name => $mode) {
                                    echo "<option value='" . $name . "'>" . $name . "</option>";
                                }
                            ?>
                        </select></td>
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
                            echo "<a class='room clickable' href='join_room.php?room-id=" . $room["id"] . "'>";
                            echo    "<img class='icon' src='data/icons/" . $room["mode"] . ".png'>";
                            echo    "<span class='name'>" . $room["name"] . "</span>";
                            echo    "<span class='players'>" . $room["players"] . " / " . $modes[$room["mode"]]["limit"] . "</span>";
                            echo "</a>";
                        }
                    ?>
                </div>
            </div>

        </div>

    </div>

</body>
</html>

<?php
    close_file($rooms_file);
?>