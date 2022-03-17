<?php
    
    if (isset($_POST["username"]) && isset($_POST["password"])) {

        $nom =$_POST["username"];
        $pass = password_hash($_POST["password"], PASSWORD_BCRYPT);

        $json_string = file_get_contents('data/log.json');
        $data = json_decode($json_string, true);

        foreach ($data as $etu) {
            if($etu['username'] == $nom) {
                header("Location: inscription_form.php?deja_utilise");
                return;
            }  
        }

        $id = str_replace(".", "", uniqid("", true));

        array_push($data, [ 'username' => $nom, 'password' => $pass, 'id' => $id ]);

        file_put_contents("data/log.json", json_encode($data, JSON_PRETTY_PRINT));

        file_put_contents("data/users/" . $id . ".json", '{ "history": [] }');

        session_start();
        $_SESSION["username"] = $nom;
        $_SESSION["id"] = $id;
    }

    header("Location: index.php");
?>