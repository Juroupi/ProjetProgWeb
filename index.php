<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Projet</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script.js"></script>
</head>
<body>

    <form action="connexion.php" method="post">

        <label for="pseudo">Pseudo</label>
        <input type="text" placeholder="Entrer son pseudo" name="pseudo" required><br>
      
        <label for="password">Mot de passe</label>
        <input type="password" placeholder="Entrer son mot de passe" name="password" required><br>

        <button type="submit">Connexion</button><br>

        <a href="inscription_form.php">S'inscrire</a>

    </form>

</body>
</html>