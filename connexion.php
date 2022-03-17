<?php

    if (isset($_POST["username"]) && isset($_POST["password"])) {

        $nom =$_POST["username"];
        $pass = $_POST["password"];

        $json_string = file_get_contents('data/log.json');
        $data = json_decode($json_string, true);

        foreach ($data as $etu) {
            if($etu['username'] == $nom && $etu['password'] == $pass) {
                session_start();
                $_SESSION["username"] = $nom;
                $_SESSION["id"] = $id;
                header("Location: profile.php");
                return;
            }  
        }
    }
    
    header("Location: index.php?identifiants_invalides");
?>