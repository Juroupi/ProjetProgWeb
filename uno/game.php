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
    <link rel="stylesheet" href="../menu.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="game.js" defer></script>
</head>
<body>

    <div id="game-grid">
        
        <div></div>

        <div id='joueur_haut'>
            
        </div>

        <div></div>

        <div id='joueur_gauche'>
            
        </div>

        <div id='tapis' class="border">
            <div class="carte" id='pioche' onclick="pioche()">
                <img src="cartes/card_back.png">
            </div>
            <div id='pile'>

            </div>
        </div>

        <div id='joueur_droite'>
            
        </div>

        <div></div>

        <div id='joueur_bas'>
            
        </div>

        <div></div>
    </div>

    <div id="chat" class="border">
        <div id="messages">
        </div>
        <div>
            <input id="message-input" type="text">
            <button id="message-submit" onclick="envoyer_message()">Envoyer</button>
        </div>
        <div id="chat-toggle" onclick="toggleChat()">▼</div>
    </div>

    <a id="leave-button" class="clickable" href="update.php?leave_room">Quitter</a>

</body>
</html>