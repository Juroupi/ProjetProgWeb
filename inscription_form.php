<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="connexion.css">
</head>
<body>

<?php
    if (isset($_GET["deja_utilise"])) {
        echo "<script>window.onload = () => alert('Pseudo déjà utilisé');</script>";
    }
?>

    <form action="inscription.php" method="post">

        <table>
            <tr>
                <th colspan="2">Inscription</th>
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
                <td><a href="index.php">Connexion</a></td>
                <td><button type="submit">S'inscrire</button></td>
            </tr>
        </table>

    </form>

</body>
</html>