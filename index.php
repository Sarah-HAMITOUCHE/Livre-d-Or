<?php
session_start();
var_dump($_SESSION);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Accueil - Livre d'or</title>
    <link rel="stylesheet" href="assets/style/styles.css">
</head>
<body>
    <div class="title">
       <h1>Bienvenue chers invités sur notre livre d'or</h1>
    </div>

    <div class="colonne">
    <a href="pages/inscription.php">S'inscrire</a> | <a href="pages/connexion.php">Se connecter</a> | <a href="pages/livre-or.php">Livre d'or</a>
    </div>
</body>
</html>