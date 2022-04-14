<?php

    include_once "files.php";

    session_start();

    if (isset($_SESSION["id"]) && isset($_GET["room-id"])) {

        $playerid = $_SESSION["id"];
        $roomid = $_GET["room-id"];

        $rooms_file = open_file('data/rooms.json');
        $rooms_infos = get_file_content($rooms_file);

        $modes = json_decode(file_get_contents('data/modes.json'), true);

        for ($i = 0; $i < count($rooms_infos); $i++) {

            if($rooms_infos[$i]['id'] == $roomid) {

                $room_file = open_file('data/rooms/' . $roomid . '.json');
                $room_content = get_file_content($room_file);

                $players_num = $rooms_infos[$i]["players"];
                $mode = $rooms_infos[$i]["mode"];
                $players_lim = $modes[$mode]["limit"];

                if (!isset($room_content["players"][$playerid]) && $players_num < $players_lim) {

                    $rooms_infos[$i]["players"] = $players_num + 1;
                    $room_content["players"][$playerid] = new stdClass();

                    set_file_content($rooms_file, $rooms_infos);
                    set_file_content($room_file, $room_content);
                }

                close_file($room_file);
                close_file($rooms_file);

                include "history.php";
                addToHistory($playerid, $rooms_infos[$i]["name"], $mode, $roomid);

                if (isset($_SESSION["room-id"]) && $_SESSION["room-id"] != $roomid) {
                    include "leave_room.php";
                }

                $_SESSION["room-id"] = $roomid;
                $_SESSION["cur-message"] = 0;

                header("Location: " . strtolower($mode) . "/game.php");

                return;
            }
        }

        close_file($rooms_file);
    }

    header("Location: index.php");
?>