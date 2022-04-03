<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["id"]) && isset($_SESSION["room-id"])) {

        $playerid4 = $_SESSION["id"];
        $roomid4 = $_SESSION["room-id"];
        unset($_SESSION["room-id"]);

        $rooms_infos4 = json_decode(file_get_contents('data/rooms.json'), true);

        for ($i4 = 0; $i4 < count($rooms_infos4); $i4++) {

            if($rooms_infos4[$i4]['id'] == $roomid4) {

                $room_filename4 = 'data/rooms/' . $roomid4 . '.json';
                $room_content4 = json_decode(file_get_contents($room_filename4), true);

                if (isset($room_content4["players"][$playerid4])) {

                    $rooms_infos4[$i4]["players"] -= 1;
                    unset($room_content4["players"][$playerid4]);

                    if ($rooms_infos4[$i4]["players"] == 0) {
                        array_splice($rooms_infos4, $i4, 1);
                        unlink($room_filename4);
                    }
                    
                    else {
                        file_put_contents($room_filename4, json_encode($room_content4, JSON_PRETTY_PRINT));
                    }

                    file_put_contents("data/rooms.json", json_encode($rooms_infos4, JSON_PRETTY_PRINT));
                }

                break;
            }
        }
    }
?>