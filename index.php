<?php
    session_start();
    if (isset($_REQUEST["deconnecte"])) {
        unset($_SESSION["username"]);
        unset($_SESSION["id"]);
    }
    if (isset($_SESSION["username"]) && isset($_SESSION["id"])) {
        header("Location: profile.php");
    } else {
        header("Location: connexion_form.php");
    }
?>