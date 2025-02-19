<?php
$conn = new PDO("mysql:host=localhost;dbname=livreor", "root", "");
require_once 'database.php';
if (isset($_POST['submit'])) {
    $login = htmlspecialchars($_POST['login']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header("Location: livre-or.php");
    } else {
        echo "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Livre d'or</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Lucida calligraphy', cursive;
}

body {
    background: url('../assets/photos/photo7.jpg') no-repeat center center;
    background-size: contain;
    text-align: center;
    padding-top: 10px;
    padding-left: 30%;
    color: white;
    min-height: 100vh;
    background-color: rgb(248, 240, 236);
}
.title {
    height: 350px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-size: 2rem;
        margin-top: 10%;
    color: white;
    text-shadow: 2px 2px 5px rgba(31, 32, 29, 0.7);
}

.title h1 {
    margin-top: 10%;
    font-size: 2rem;
    background: rgba(210, 130, 9, 0.2);
    padding: 15px 25px;
    border-radius: 20px;
    font-size: 2rem;
    
}

.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-right: 80px;
    justify-content: center;
    height: 80vh;
}

.form-section {
    text-shadow: 2px 2px 5px rgba(31, 32, 29, 0.7);
    background: rgba(196, 163, 139, 0.6);
    padding: 30px;
    margin: 20px auto;
    border-radius: 10px;
    width: 40%;
        
}

h2 {
    font-size: 2rem;
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
    width: 80%;
    font-size: 1rem;
}

button {
    background-color: rgb(175, 158, 80);
    color: rgb(225, 225, 214);
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
}

button:hover {
    background-color: rgb(233, 238, 209);
}
@media (max-width: 768px) {
            .form-section {
                width: 60%;
            }

            .title h1 {
                font-size: 1.5rem;
            }

            input {
                width: 90%;
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
</head>
<body>
    <div class="container">
        <div class="title">
        <h1>Connexion</h1>
        </div>
        <form class="form-section" method="post">
            <input type="text" name="login" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="submit">Se connecter</button>
        </form>
        <?php
        session_start();
        $conn = new PDO("mysql:host=localhost;dbname=livreor", "root", "");

        if (isset($_POST['submit'])) {
            $login = htmlspecialchars($_POST['login']);
            $password = $_POST['password'];
   

            $stmt = $conn->prepare("SELECT * FROM user WHERE login = ?");
            $stmt->execute([$login]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: livre-or.php");
            } else {
                echo "<p style='color:red;'>Identifiants incorrects.</p>";
                
            } 

            }

        ?>
    </div>
</body>
</html>