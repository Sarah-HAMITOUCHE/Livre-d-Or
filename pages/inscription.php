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
<style>
       * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Lucida Calligraphy', cursive;
        }
        
        .title {
            height: 350px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            text-shadow: 2px 2px 5px rgba(31, 32, 29, 0.7);
        }
        
        .title h1 {
            font-size: 2rem;
            background: rgba(210, 130, 9, 0.2);
            padding: 15px 25px;
            margin-top: 10%;
            border-radius: 20px;
        }
        
        body {
            background: url('../assets/photos/photo6.jpg');
            background-size: cover;
            text-align: center;
            padding-top: 10px;
            color: white;
            min-height: 100vh;
            background-color:rgb(248, 240, 236);
        }
        
        .form-section {
            text-shadow: 2px 2px 5px rgba(31, 32, 29, 0.7);
            background: rgba(196, 163, 139, 0.6);
            padding: 10px;
            margin: 20px auto;
            border-radius: 10px;
            width: 30%;
        }
        
        h2 {
            font-size: rem;
            margin-bottom: 20px;
        }
        
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }
        
        input {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid rgb(184, 154, 154);
            width: 300px;
            font-size: 1rem;
        }
        
        button {
            background-color:rgb(175, 158, 80);
            color: rgb(255, 255, 255);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            text-shadow: 2px 2px 5px rgba(31, 32, 29, 0.7);
        }
        
        button:hover {
            background-color:rgb(255, 255, 255);
        }
        button a:hover{
            text-decoration: underline;
        }

        .success-message {
            color: rgb(255, 255, 255);
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
        .connect{
            background-color:rgb(175, 158, 80);
            color: rgb(225, 225, 214);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
        .connect:hover{
            background-color:rgb(233, 238, 209);
        }
        .connect a:hover{
            text-decoration: underline;
        }

        .success-message a {
            color:rgb(255, 255, 255);
            font-weight: bold;
            text-decoration: none;
        }
        @media (max-width: 768px) {
            .form-section {
                width: 50%;
            }

            .title h1 {
                font-size: 1.5rem;
            }

            input {
                width: 80%;
            }

            button {
                font-size: 0.9rem;
                padding: 8px 16px;
            }
        }
        @media (max-width: 480px) {
            .form-section {
                width: 80%;
            }

            .title h1 {
                font-size: 1.2rem;
            }

            input {
                width: 100%;
            }

            button {
                font-size: 0.8rem;
                padding: 6px 12px;
            }
        }
</style>
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
