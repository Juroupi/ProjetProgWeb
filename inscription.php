<?php
    
    if (isset($_POST["username"]) && isset($_POST["password"])) {

        $nom =$_POST["username"];
        $pass = $_POST["password"];

        $json_string = file_get_contents('data/log.json');
        $data = json_decode($json_string, true);

        foreach ($data as $etu) {
            if($etu['username'] == $nom) {
                header("Location: inscription_form.php?deja_utilise");
                return;
            }  
        }

        array_push($data, [ 'username' => $nom, 'password' => $pass ]);

        file_put_contents("data/log.json", json_encode($data, JSON_PRETTY_PRINT));

        header("Location: jeu.html");
    }

    echo "erreur";
?>