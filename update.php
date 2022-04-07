<?php

    session_start();

    if (isset($_SESSION["username"]) && isset($_SESSION["id"]) && isset($_SESSION["room-id"])) {

        $playerid = $_SESSION["id"];
        $playername = $_SESSION["username"];
        $roomid = $_SESSION["room-id"];
        $room_filename = 'data/rooms/' . $roomid . '.json';
        $room = json_decode(file_get_contents($room_filename), true);

        if (isset($_REQUEST["message"])) {

            if (!isset($room["messages"])) {
                $room["messages"] = [];
            }

            array_push($room["messages"], [ $playername, strip_tags($_REQUEST["message"]) ]);

            file_put_contents($room_filename, json_encode($room));
        } 
        
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

        else if (isset($_REQUEST["play-card"])) {

            $card = $_REQUEST["play-card"];

            if ($card < count($room[$playerid]["cards"])) {

                if (!isset($room["pile"])) {
                    $room["pile"] = [];
                }

                array_push($room["pile"], $room[$playerid]["cards"][$card]);

                array_splice($room[$playerid]["cards"], $card, 1);

                file_put_contents($room_filename, json_encode($room));
            }
        }

        else if (isset($_REQUEST["pick-card"])) {

            if (!isset($room["deck"])) {
                $room["deck"] = [];
                // initialisation de la pioche
            }

            array_push($room[$playerid]["cards"], $room["deck"][0]);

            array_splice($room["deck"], 0, 1);

            file_put_contents($room_filename, json_encode($room));
        } 
    }

?>