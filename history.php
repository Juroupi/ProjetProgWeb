<?php
	function addToHistory($playerid, $roomname, $mode, $roomid) {
		if (!isset($_SESSION["room-id"]) || $roomid != $_SESSION["room-id"]) {
	        $player_file = open_file("data/users/" . $playerid . ".json");
	        $player_infos = get_file_content($player_file);
	        date_default_timezone_set("Europe/Paris");
	        array_push($player_infos["history"], 
	            array("mode" => $mode, "room-name" => $roomname, "room-id" => $roomid, "time" => date("H:i d/m/y")));
	        set_file_content($player_file, $player_infos);
	        close_file($player_file);
	    }
	}
?>