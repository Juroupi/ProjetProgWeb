<?php

    include_once "../files.php";

    session_start();

    if (isset($_SESSION["username"]) && isset($_SESSION["id"]) && isset($_SESSION["room-id"])) {

        $playerid = $_SESSION["id"];
        $playername = $_SESSION["username"];
        $roomid = $_SESSION["room-id"];

        $room_filename = '../data/rooms/' . $roomid . '.json';
        $room_file = open_file($room_filename);
        $room = get_file_content($room_file);

        if (!isset($room["pile"])) {
            $room["pile"] = [];
        }

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

        // envoyer un message
        if (isset($_REQUEST["message"])) {

            if (!isset($room["messages"])) {
                $room["messages"] = [];
            }

            $content = strip_tags($_REQUEST["message"]);

            if (count($content) > 0) {

                array_push($room["messages"], [ $playername, $content ]);

                set_file_content($room_file, $room);
            }
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

            if ($card < count($room["players"][$playerid]["cards"])) {

                array_push($room["pile"], $room["players"][$playerid]["cards"][$card]);

                array_splice($room["players"][$playerid]["cards"], $card, 1);

                set_file_content($room_file, $room);
            }
        }

        // piocher une carte
        else if (isset($_REQUEST["pick-card"])) {

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

            // si la pioche est vide, on la remplie avec la pile (à tester)
            else if (empty($room["deck"]) && count($room["pile"]) > 1) {
                $room["deck"] = array_slice($room["pile"], -1);
                $room["pile"] = [ $room["pile"][count($room["pile"]) - 1] ];
            }

            // on retire la carte de la pioche et on la donne au joueur
            if (!empty($room["deck"])) {
                array_push($room["players"][$playerid]["cards"], $room["deck"][0]);
                array_splice($room["deck"], 0, 1);
            }

            set_file_content($room_file, $room);
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

        close_file($room_file);
    }

?>