<?php

    session_start();

    if (!isset($_SESSION["username"]) || !isset($_SESSION["id"]) || !isset($_SESSION["room-id"])) {
        header("Location: ../profile.php");
        exit;
    }
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
            <div id='pioche' onclick="pioche()">
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

        </div>
    </div>

    <div id="chat">
        <div id="messages">
        </div>
        <div>
            <input id="message-input" type="text">
            <button id="message-submit" onclick="envoyer_message()">Envoyer</button>
        </div>
        <div id="chat-toggle" onclick="toggleChat()">▼</div>
    </div>

</body>
</html>