<?php

    function color($card_name) {
        if(strpos($card_name, "blue") !== false){
            return 'blue';
        }
        if(strpos($card_name, "green") !== false){
            return 'green';
        }
        if(strpos($card_name, "red") !== false){
            return 'red';
        }
        if(strpos($card_name, "yellow") !== false){
            return 'yellow';
        }
        return '';
    }
    
    function valid_move(&$room, $play_card) {
        
        $top_card = $room["pile"][count($room["pile"]) - 1];

        $num_top = substr($top_card, -1);
        $num_play = substr($play_card, -1);
        
        $color_top = color($top_card);
        $color_play = color($play_card);

        if (ctype_digit($num_top) && ctype_digit($num_play) && strcmp($num_top, $num_play) == 0) {
            return true;
        }

        if (strlen($color_top) > 0 && strlen($color_play) > 0 && strcmp($color_top, $color_play) == 0) {
            return true;
        }

        if (strpos($top_card, "picker")!== false  && strpos($play_card, "picker")!== false ) {
            return true;
        }

        if (strpos($top_card, "reverse")!== false  && strpos($play_card, "reverse")!== false ) {
            return true;
        }

        if (strpos($top_card, "skip") !== false && strpos($play_card, "skip") !== false) {
            return true;
        }

        if (strpos($top_card, "wild") !== false || strpos($play_card, "wild") !== false) {
            return true;
        }
        
        return false;
    }
?>