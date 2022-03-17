<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="connexion.css">
</head>
<body>

<?php
    if (isset($_GET["identifiants_invalides"])) {
        echo "<script>window.onload = () => alert('Identifiants invalides');</script>";
    }
?>

    <form action="connexion.php" method="post">

        <table>
            <tr>
                <th colspan="2">Connexion</th>
            </tr>
            <tr>
                <td><label for="username">Pseudo</label></td>
                <td><input type="text" placeholder="Entrer son pseudo" name="username" required></td>
            </tr>
            <tr>
                <td><label for="password">Mot de passe</label></td>
                <td><input type="password" placeholder="Entrer son mot de passe" name="password" required></td>
            </tr>
            <tr>
                <td><a href="inscription_form.php">Inscription</a></td>
                <td><button type="submit">Se connecter</button></td>
            </tr>
        </table>
        
    </form>

</body>
</html>