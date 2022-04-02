<?php

    session_start();

    if (isset($_SESSION["id"]) && isset($_GET["room-id"])) {

        $playerid = $_SESSION["id"];
        $roomid = $_GET["room-id"];

        $rooms_infos = json_decode(file_get_contents('data/rooms.json'), true);

        for ($i = 0; $i < count($rooms_infos); $i++) {

            if($rooms_infos[$i]['id'] == $roomid) {

                $room_filename = 'data/rooms/' . $roomid . '.json';
                $room_content = json_decode(file_get_contents($room_filename), true);

                if (isset($room_content["players"][$playerid])) {

                    $rooms_infos[$i]["players"] -= 1;
                    unset($room_content["players"][$playerid]);

                    if ($rooms_infos[$i]["players"] == 0) {
                        unset($rooms_infos[$i]);
                        unlink($room_filename);
                    }
                    
                    else {
                        file_put_contents($room_filename, json_encode($room_content, JSON_PRETTY_PRINT));
                    }

                    file_put_contents("data/rooms.json", json_encode($rooms_infos, JSON_PRETTY_PRINT));
                }

                header("Location: profile.php");

                return;
            }
        }
    }

    header("Location: index.php");
?>