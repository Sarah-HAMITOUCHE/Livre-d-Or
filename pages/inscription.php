<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Livre d'or</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            margin: 50px auto;
            width: 60%;
            max-width: 400px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <form action="" method="post">
            <input type="text" name="login" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="submit">S'inscrire</button>
        </form>
        <?php

        $conn = new PDO("mysql:host=localhost;dbname=livreor", "root", "");

        if (isset($_POST['submit'])) {
            $login = htmlspecialchars($_POST['login']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO user (login, password) VALUES (?, ?)");
            if ($stmt->execute([$login, $password])) {
                echo "<p style='color:green;'>Inscription réussie ! <a href='connexion.php'>Connectez-vous</a></p>";
            } else {
                echo "<p style='color:red;'>Erreur lors de l'inscription.</p>";
            }
        }
        ?>
    </div>
</body>
</html>