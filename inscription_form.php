<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
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

        <label for="pseudo">Pseudo</label>
        <input type="text" placeholder="Entrer son pseudo" name="pseudo" required><br>
      
        <label for="password">Mot de passe</label>
        <input type="password" placeholder="Entrer son mot de passe" name="password" required><br>

        <button type="submit">Inscription</button>

    </form>

</body>
</html>