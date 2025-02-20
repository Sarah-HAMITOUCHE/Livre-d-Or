<?php
        require_once 'classes/User.php';

        if (isset($_POST['submit'])) {
            $login = htmlspecialchars($_POST['login']);
            $password = $_POST['password'];

            $user = new User();
            $userId = $user->register($login, $password);

            if ($userId) {
                echo "<div class='success-message'>Inscription réussie <a href='connexion.php' class='connect'>Connexion</a></div>";
            } else {
                echo "<p style='color:red;'>Erreur lors de l'inscription.</p>";
            }
        }
        ?>
        
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../assets/style/styles.css">
    <link rel="stylesheet" href="../assets/style/inscription.css">


</head>
<body>
    <div class="title">
        <h1>Inscription</h1>
    </div>
    
    <div class="container form-section">
        <h2>Créer un compte</h2>
        <form action="" method="post">
            <input type="text" name="login" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="submit"><strong>S'inscrire</strong></button>
        </form>
        

    </div>
 
</body>
</html>
</html>
