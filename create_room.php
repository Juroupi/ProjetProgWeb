<?php

    session_start();

    if (isset($_SESSION["id"]) && isset($_GET["game-mode"]) && isset($_GET["room-name"])) {

        $name = $_GET["room-name"];
        $mode = $_GET["game-mode"];

        $rooms = json_decode(file_get_contents('data/rooms.json'), true);
        $modes = json_decode(file_get_contents('data/modes.json'), true);

        if (!isset($modes[$mode])) {
            header("Location: profile.php?mode_invalide");
            return;
        }

        foreach ($rooms as $room) {
            if($room['name'] == $name) {
                header("Location: profile.php?deja_utilise");
                return;
            }  
        }

        $roomid = str_replace(".", "", uniqid("", true));
        $playerid = $_SESSION["id"];

        array_push($rooms, [ 'name' => $name, 'mode' => $mode, 'players' => 1, 'id' => $roomid ]);

        file_put_contents("data/rooms.json", json_encode($rooms, JSON_PRETTY_PRINT));

        file_put_contents("data/rooms/" . $roomid . ".json", '{ "players": { "' . $playerid . '": {} } }');

        header("Location: game.php?id=" . $roomid);
    }

    else {
        header("Location: index.php");
    }
?>