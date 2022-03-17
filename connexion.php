<?php

    session_start();

    if (isset($_POST["username"]) && isset($_POST["password"])) {

        $nom = $_POST["username"];
        $pass = $_POST["password"];

        $json_string = file_get_contents('data/log.json');
        $data = json_decode($json_string, true);

        foreach ($data as $etu) {
            if($etu['username'] == $nom && password_verify($pass, $etu['password'])) {
                $_SESSION["username"] = $nom;
                $_SESSION["id"] = $etu['id'];
                header("Location: profile.php");
                return;
            }
        }
    }
    
    header("Location: connexion_form.php?identifiants_invalides");
?>