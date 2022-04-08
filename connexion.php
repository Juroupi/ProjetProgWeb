<?php

    include_once "files.php";

    session_start();

    if (isset($_POST["username"]) && isset($_POST["password"])) {

        $nom = strip_tags($_POST["username"]);
        $pass = strip_tags($_POST["password"]);

        $log_file = open_file("data/log.json");
        $data = get_file_content($log_file);

        foreach ($data as $etu) {
            if($etu['username'] == $nom && password_verify($pass, $etu['password'])) {
                $_SESSION["username"] = $nom;
                $_SESSION["id"] = $etu['id'];
                close_file($log_file);
                header("Location: profile.php");
                return;
            }
        }

        close_file($log_file);
    }
    
    header("Location: connexion_form.php?identifiants_invalides");
?>