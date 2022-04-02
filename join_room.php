<?php

    session_start();

    if (isset($_SESSION["id"]) && isset($_GET["room-id"])) {

        $playerid = $_SESSION["id"];
        $roomid = $_GET["room-id"];

        $rooms_infos = json_decode(file_get_contents('data/rooms.json'), true);
        $modes = json_decode(file_get_contents('data/modes.json'), true);

        for ($i = 0; $i < count($rooms_infos); $i++) {

            if($rooms_infos[$i]['id'] == $roomid) {

                $room_filename = 'data/rooms/' . $roomid . '.json';
                $room_content = json_decode(file_get_contents($room_filename), true);

                $players_num = $rooms_infos[$i]["players"];
                $players_lim = $modes[$rooms_infos[$i]["mode"]]["limit"];

                if (!isset($room_content["players"][$playerid]) && $players_num < $players_lim) {

                    $rooms_infos[$i]["players"] = $players_num + 1;
                    $room_content["players"][$playerid] = new stdClass();

                    file_put_contents("data/rooms.json", json_encode($rooms_infos, JSON_PRETTY_PRINT));
                    file_put_contents($room_filename, json_encode($room_content, JSON_PRETTY_PRINT));
                }

                header("Location: game.php?id=" . $roomid);

                return;
            }
        }
    }

    header("Location: index.php");
?>