<?php

    include_once "files.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["id"]) && isset($_SESSION["room-id"])) {

        $playerid4 = $_SESSION["id"];
        $roomid4 = $_SESSION["room-id"];
        unset($_SESSION["room-id"]);

        $rooms_file4 = open_file('data/rooms.json');
        $rooms_infos4 = get_file_content($rooms_file4);

        for ($i4 = 0; $i4 < count($rooms_infos4); $i4++) {

            if($rooms_infos4[$i4]['id'] == $roomid4) {

                $room_filename4 = 'data/rooms/' . $roomid4 . '.json';
                $room_file4 = open_file($room_filename4);
                $room_content4 = get_file_content($room_file4);

                if (isset($room_content4["players"][$playerid4])) {

                    $rooms_infos4[$i4]["players"] -= 1;
                    unset($room_content4["players"][$playerid4]);

                    if ($rooms_infos4[$i4]["players"] == 0) {
                        array_splice($rooms_infos4, $i4, 1);
                        close_file($room_file4);
                        unlink($room_filename4);
                    }
                    
                    else {
                        set_file_content($room_file4, $room_content4);
                        close_file($room_file4);
                    }

                    set_file_content($rooms_file4, $rooms_infos4);
                }

                break;
            }
        }

        close_file($rooms_file4);

        if (isset($_REQUEST["redirect"])) {
            header("Location: profile.php");
        }
    }
?>