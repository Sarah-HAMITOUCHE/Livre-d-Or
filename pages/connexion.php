<?php
require_once 'classes/User.php';
session_start();

if (isset($_POST['submit'])) {
    $login = htmlspecialchars($_POST['login']);
    $password = $_POST['password'];

    $user = new User();
    $authenticatedUser = $user->login($login, $password);

    if ($authenticatedUser) {
        $_SESSION['user'] = $authenticatedUser['login'];
        $_SESSION['user_id'] = $authenticatedUser['id'];
        header("Location: livre-or.php");
        exit();
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Livre d'or</title>
    <link rel="stylesheet" href="../assets/style/styles.css">
    <link rel="stylesheet" href="../assets/style/connexion.css">
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>Connexion</h1>
        </div>
        <form class="form-section" method="POST">
            <h2>Se connecter</h2>
            <input type="text" name="login" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="submit">Se connecter</button>
        </form>
        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>$error</p>";
        }
        ?>
    </div>
</body>
</html>