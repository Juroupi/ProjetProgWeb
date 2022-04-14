<?php

    include_once "../files.php";

    function addMessage(&$room_file, &$room, $name, $msg) {

        if (!isset($room["messages"])) {
            $room["messages"] = [];
        }

        $content = strip_tags($msg);

        if (count($content) > 0) {

            array_push($room["messages"], [ $name, $content ]);

            set_file_content($room_file, $room);
        }
    }

    session_start();

    if (isset($_SESSION["username"]) && isset($_SESSION["id"]) && isset($_SESSION["room-id"])) {

        $playerid = $_SESSION["id"];
        $playername = $_SESSION["username"];
        $roomid = $_SESSION["room-id"];

        $room_filename = '../data/rooms/' . $roomid . '.json';
        $room_file = open_file($room_filename);
        $room = get_file_content($room_file);

        if (!isset($room["tour"])) {
            $room["tour"] = $playerid;
            unset($room["message-tour"]);
        }
        $joueur_suivant = false;

        if (!isset($room["pile"])) {
            $room["pile"] = [];
        }

        if (!isset($room["messages"])) {
            $room["messages"] = [];
        }

        if (!isset($room["sens"])) {
            $room["sens"] = true;
        }

        if (!isset($room["players"][$playerid])) {
            close_file($room_file);
            exit;
        }

        if (!isset($room["players"][$playerid]["cards"])) {
            $room["players"][$playerid]["cards"] = [];
        }

        // envoyer un message
        if (isset($_REQUEST["message"])) {
            addMessage($room_file, $room, $playername, $_REQUEST["message"]);
        } 
        
        // récupérer les nouveaux messages
        else if (isset($_REQUEST["new-messages"])) {

            $first = $_SESSION["cur-message"];

            if (isset($room["messages"]) && $first < count($room["messages"])) {
                
                $new_messages = array_slice($room["messages"], $first);

                $_SESSION["cur-message"] = count($room["messages"]);

                echo json_encode($new_messages);
            }

            else {
                echo "[]";
            }
        }

        // jouer une carte si c'est notre tour
        else if (isset($_REQUEST["play-card"]) && $room["tour"] == $playerid) {

            $card = $_REQUEST["play-card"];

            include_once "rules.php";

            if ($card < count($room["players"][$playerid]["cards"]) && check_rules($room, $card)) {

                array_push($room["pile"], $room["players"][$playerid]["cards"][$card]);

                array_splice($room["players"][$playerid]["cards"], $card, 1);

                $joueur_suivant = true;
            }
        }

        // piocher une carte si c'est notre tour
        else if (isset($_REQUEST["pick-card"]) && $room["tour"] == $playerid) {

            // creation de la pioche si elle n'est pas définie
            if (!isset($room["deck"])) {

                $room["deck"] = [];

                $colors = array("blue", "green", "red", "yellow");

                foreach ($colors as $color) {
                    array_push($room["deck"], $color . "_0");
                    for ($i = 0; $i < 2; $i++) {
                        for ($n = 1; $n <= 9; $n++) {
                            array_push($room["deck"], $color . "_" . $n);
                        }
                        array_push($room["deck"], $color . "_picker");
                        array_push($room["deck"], $color . "_reverse");
                        array_push($room["deck"], $color . "_skip");
                    }
                    array_push($room["deck"], "wild_pick_four");
                    array_push($room["deck"], "wild_color_changer");
                }

                shuffle($room["deck"]);
            }

            // si la pioche est vide, on la remplie avec la pile
            else if (empty($room["deck"]) && count($room["pile"]) > 1) {
                $room["deck"] = array_slice($room["pile"], 0, -1);
                $room["pile"] = [ $room["pile"][count($room["pile"]) - 1] ];
            }

            // on retire la carte de la pioche et on la donne au joueur
            if (!empty($room["deck"])) {
                
                $nombre_cartes = 1;

                if (!isset($room["players"][$playerid]["deja-joue"])) {
                    $nombre_cartes = 7;
                    $room["players"][$playerid]["deja-joue"] = true;
                }

                for ($i = 0; $i < $nombre_cartes; $i++) {
                    array_push($room["players"][$playerid]["cards"], $room["deck"][0]);
                    array_splice($room["deck"], 0, 1);
                }
            }

            $joueur_suivant = true;
        }

        // récupérer l'état du jeu
        else if (isset($_REQUEST["cards"])) {

            $top = "empty";
            if (count($room["pile"]) > 0) {
                $top = $room["pile"][count($room["pile"]) - 1];
            }

            $others = [];
            foreach ($room["players"] as $otherid => $otherplayer) {

                if ($otherid != $playerid) {

                    if (!isset($otherplayer["cards"])) {
                        $otherplayer["cards"] = [];
                    }

                    array_push($others, count($otherplayer["cards"]));
                }
            }

            echo '{';
            echo '"top": "' . $top . '", ';
            echo '"cards": ' . json_encode($room["players"][$playerid]["cards"]) . ', ';
            echo '"others": ' . json_encode($others);
            echo '}';
        }

        // gestion des tours
        if ($joueur_suivant || !isset($room["players"][$room["tour"]])) {

            $players_id = array_keys($room["players"]);
            $next_player_id = false;
            sort($players_id);
            if ($room["sens"]) {
                foreach ($players_id as $id) {
                    if (strcmp($id, $room["tour"]) > 0) {
                        $next_player_id = $id;
                    }
                }
            } else {
                foreach ($players_id as $id) {
                    if (strcmp($id, $room["tour"]) < 0) {
                        $next_player_id = $id;
                    }
                }
            }

            if ($next_player_id == false) {
                if ($room["sens"]) {
                    $room["tour"] = $players_id[0];
                } else {
                    $room["tour"] = $players_id[count($players_id) - 1];
                }
            }
            else {
                $room["tour"] = $next_player_id;
            }

            unset($room["message-tour"]);

            set_file_content($room_file, $room);
        }

        // affichage du message de tour
        if (!isset($room["message-tour"]) && $playerid == $room["tour"]) {
            $room["message-tour"] = true;
            addMessage($room_file, $room, "serveur", "c'est le tour de " . $playername);
            set_file_content($room_file, $room);
        }

        close_file($room_file);
    }

?>