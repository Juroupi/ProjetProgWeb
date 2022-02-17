<?php

    if (isset($_POST["pseudo"]) && isset($_POST["password"])) {

        $nom =$_POST["pseudo"];
        $pass = $_POST["password"];

        $json_string = file_get_contents('log.json');
        $data = json_decode($json_string, true);

        foreach ($data as $etu) {
            if($etu['pseudo'] == $nom && $etu['password'] == $pass) {
                header("Location: jeu.html");
                return;
            }  
        }
    }
    
    header("Location: index.php");
?>