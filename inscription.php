<?php
    
    if (isset($_POST["pseudo"]) && isset($_POST["password"])) {

        $nom =$_POST["pseudo"];
        $pass = $_POST["password"];

        $json_string = file_get_contents('log.json');
        $data = json_decode($json_string, true);

        foreach ($data as $etu) {
            if($etu['pseudo'] == $nom) {
                header("Location: inscription_form.php?deja_utilise");
                return;
            }  
        }

        array_push($data, [ 'pseudo' => $nom, 'password' => $pass ]);

        file_put_contents("log.json", json_encode($data, JSON_PRETTY_PRINT));

        header("Location: jeu.html");
    }

    echo "erreur";
?>