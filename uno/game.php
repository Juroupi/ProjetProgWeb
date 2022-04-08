<?php

    session_start();

    if (!isset($_GET["id"]) || !isset($_SESSION["username"]) || !isset($_SESSION["id"]) || !ctype_alnum($_GET["id"])) {
        header("Location: ../profile.php");
        exit;
    }

    $roomid = $_GET["id"];

    $json_string = @file_get_contents('../data/rooms/' . $roomid . '.json');
    if($json_string === FALSE) {
        header("Location: ../profile.php");
        exit;
    }

    $room = json_decode($json_string, true);

    /* gérer room */
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Jeu</title>
    <link rel="stylesheet" href="game.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="game.js" defer></script>
</head>
<body>

    <div id='joueur_haut'>
        <div class="cartes">
                
        </div>
    </div>

    <div>
        <div id='joueur_gauche'>
            <div class="cartes">
                
            </div>
        </div>

        <div id='tapis'>
            <div id='pioche'>
                <img src="cartes/card_back.png">
            </div>
            <div id='pile'>

            </div>
        </div>

        <div id='joueur_droite'>
            <div class="cartes">
                
            </div>
        </div>
    </div>

    <div id='joueur_bas'>
        <div class="cartes">
                <div class="carte" onclick = "empile(this)"><img src="cartes/green_1.png" /></div>
                <div class="carte" onclick = "empile(this)"><img src="cartes/red_3.png" /></div>
                <div class="carte" onclick = "empile(this)"><img src="cartes/yellow_5.png" /></div>
                <div class="carte" onclick = "empile(this)"><img src="cartes/green_2.png" /></div>
                <div class="carte" onclick = "empile(this)"><img src="cartes/yellow_1.png" /></div>
                <div class="carte" onclick = "empile(this)"><img src="cartes/red_4.png" /></div>
        </div>
    </div>

</body>
</html>