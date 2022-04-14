<?php
    
    include_once "files.php";

    session_start();

    if (isset($_SESSION["id"]) && isset($_GET["game-mode"]) && isset($_GET["room-name"])) {

        $name = trim(strip_tags($_GET["room-name"]));
        $mode = strip_tags($_GET["game-mode"]);

        if (empty($name)) {
            header("Location: profile.php?nom_invalide");
            return;
        }

        $rooms_file = open_file('data/rooms.json');
        $rooms = get_file_content($rooms_file);

        $modes = json_decode(file_get_contents('data/modes.json'), true);

        if (!isset($modes[$mode])) {
            close_file($rooms_file);
            header("Location: profile.php?mode_invalide");
            return;
        }

        foreach ($rooms as $room) {
            if($room['name'] == $name) {
                close_file($rooms_file);
                header("Location: profile.php?deja_utilise");
                return;
            }  
        }

        $roomid = str_replace(".", "", uniqid("", true));
        $playerid = $_SESSION["id"];

        array_push($rooms, [ 'name' => $name, 'mode' => $mode, 'players' => 1, 'id' => $roomid ]);

        set_file_content($rooms_file, $rooms);

        close_file($rooms_file);

        file_put_contents("data/rooms/" . $roomid . ".json", '{ "players": { "' . $playerid . '": {} } }');

        include "history.php";
        addToHistory($playerid, $name, $mode, $roomid);

        if (isset($_SESSION["room-id"])) {
            include "leave_room.php";
        }

        $_SESSION["room-id"] = $roomid;
        $_SESSION["cur-message"] = 0;

        header("Location: " . strtolower($mode) . "/game.php");
    }

    else {
        header("Location: index.php");
    }
?>