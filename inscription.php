<?php

    include_once "files.php";

    session_start();
    
    if (isset($_POST["username"]) && isset($_POST["password"])) {

        $nom = $_POST["username"];
        $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);

        $log_file = open_file('data/log.json');
        $data = get_file_content($log_file);

        foreach ($data as $etu) {
            if($etu['username'] == $nom) {
                close_file($log_file);
                header("Location: inscription_form.php?deja_utilise");
                return;
            }  
        }

        $id = str_replace(".", "", uniqid("", true));

        array_push($data, [ 'username' => $nom, 'password' => $pass, 'id' => $id ]);

        set_file_content($log_file, $data);
        close_file($log_file);

        file_put_contents("data/users/" . $id . ".json", '{ "history": [] }');

        $_SESSION["username"] = $nom;
        $_SESSION["id"] = $id;
    }

    header("Location: index.php");
?>