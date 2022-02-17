<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="connexion.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script.js"></script>
</head>
<body>

<?php
    if (isset($_GET["deja_utilise"])) {
        echo "deja utilise<br>";
    }
?>

    <form action="inscription.php" method="post">

        <table>
            <tr>
                <td><label for="pseudo">Pseudo</label></td>
                <td><input type="text" placeholder="Entrer son pseudo" name="pseudo" required></td>
            </tr>
            <tr>
                <td><label for="password">Mot de passe</label></td>
                <td><input type="password" placeholder="Entrer son mot de passe" name="password" required></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Inscription</button></td>
            </tr>
        </table>

    </form>

</body>
</html>