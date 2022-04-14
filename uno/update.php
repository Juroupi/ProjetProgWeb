<?php

    include_once "../files.php";

    function addMessage(&$room_file, &$room, $name, $msg) {

        if (!isset($room["messages"])) {
            $room["messages"] = [];
        }

        $content = strip_tags($msg);

        if (count($content) > 0) {

            array_push($room["messages"], [ $name, $content ]);

            return true;
        }

        return false;
    }

    session_start();

    if (isset($_SESSION["username"]) && isset($_SESSION["id"]) && isset($_SESSION["room-id"])) {

        $playerid = $_SESSION["id"];
        $playername = $_SESSION["username"];
        $roomid = $_SESSION["room-id"];

        $room_filename = '../data/rooms/' . $roomid . '.json';
        $room_file = open_file($room_filename);
        $room = get_file_content($room_file);

        $save_file = false;

        if (!isset($room["messages"])) {
            $room["messages"] = [];
        }

        if (!isset($room["players"][$playerid])) {
            close_file($room_file);
            exit;
        }

        if (!isset($room["players"][$playerid]["cards"])) {
            $room["players"][$playerid]["cards"] = [];
        }

        // initialisation de la partie si ce n'est pas encore fait
        if (!isset($room["deck"]) || !isset($room["pile"])) {

            $room["commence"] = true;

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

            // on pose la première carte
            $premiere = 0;
            foreach ($room["deck"] as $i => $carte) {
                if (ctype_digit(substr($carte, -1))) {
                    $premiere = $i;
                    break;
                }
            }
            $room["pile"] = [ $room["deck"][$premiere] ];
            array_splice($room["deck"], $premiere, 1);

            $save_file = true;
        }

        // envoyer un message
        if (isset($_REQUEST["message"])) {
            $save_file = addMessage($room_file, $room, $playername, $_REQUEST["message"]);
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

        // jouer une carte
        else if (isset($_REQUEST["play-card"])) {

            $card = $_REQUEST["play-card"];

            include_once "rules.php";

            if ($card < count($room["players"][$playerid]["cards"])) {

                $play_card = $room["players"][$playerid]["cards"][$card];

                if (valid_move($room, $play_card)) {
    
                    array_push($room["pile"], $play_card);
    
                    array_splice($room["players"][$playerid]["cards"], $card, 1);
    
                    $save_file = true;
                }
            }
        }

        // piocher une carte
        else if (isset($_REQUEST["pick-card"])) {

            // si la pioche est vide, on la remplie avec la pile
            if (empty($room["deck"]) && count($room["pile"]) > 1) {
                $room["deck"] = array_slice($room["pile"], 0, -1);
                $room["pile"] = [ $room["pile"][count($room["pile"]) - 1] ];
            }

            // on retire la carte de la pioche et on la donne au joueur
            if (!empty($room["deck"])) {
                array_push($room["players"][$playerid]["cards"], $room["deck"][0]);
                array_splice($room["deck"], 0, 1);
            }

            $save_file = true;
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

        if ($save_file) {
            set_file_content($room_file, $room);
        }

        close_file($room_file);
    }

?>