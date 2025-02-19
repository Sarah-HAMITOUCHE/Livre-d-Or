<?php
session_start();
require_once 'database.php'; // Inclure le fichier de connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: connexion.php");
    exit();
}

// Récupérer les informations actuelles de l'utilisateur
$user_id = $_SESSION['user']['id'];
$stmt = $conn->prepare("SELECT login FROM user WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_login = htmlspecialchars($_POST['login']);
    $new_password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    // Vérifier que les mots de passe correspondent
    if ($new_password === $confirm_password) {
        // Hacher le nouveau mot de passe
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Mettre à jour les informations de l'utilisateur dans la base de données
        $update_stmt = $conn->prepare("UPDATE user SET login = ?, password = ? WHERE id = ?");
        $update_stmt->execute([$new_login, $hashed_password, $user_id]);

        // Mettre à jour les informations de session
        $_SESSION['user']['login'] = $new_login;

        $message = "Profil mis à jour avec succès.";
    } else {
        $message = "Les mots de passe ne correspondent pas.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Lucida Calligraphy', cursive;
}

/* Style du corps de la page */
body {
    background: url('../assets/photos/photo5.png') no-repeat center center;
    background-size: cover;
    text-align: center;
    padding-top: 90px;
    color: white;
    min-height: 100vh;
    background-color: #c8d3c7;
}

/* Conteneur principal */
.container {
    max-width: 500px;
    margin: auto;
    padding: 20px;
    background: rgba(0, 0, 0, 0.6);
    border-radius: 10px;
}

/* Titre principal */
h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    text-shadow: 2px 2px 5px rgba(31, 32, 29, 0.7);
}

/* Messages d'information */
.message {
    margin-bottom: 20px;
    padding: 10px;
    background-color:rgb(255, 254, 248);
    color:rgb(0, 0, 0);
    border-radius: 5px;
}

/* Formulaire */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    align-items: center;
}

/* Labels des champs */
label {
    font-size: 1.2rem;
    margin-bottom: 5px;
}

/* Champs de saisie */
input[type="text"],
input[type="password"] {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #f1dddd;
    width: 300px;
    font-size: 1rem;
}

/* Bouton de soumission */
button {
    background-color: #101005;
    color: rgb(231, 231, 224);
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color:rgb(142, 142, 142);
}
@media (max-width: 768px) {
    .container {
        padding: 10px;
    }

    h1 {
        font-size: 2rem;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
    }

    button {
        font-size: 0.9rem;
        padding: 8px 16px;
    }
}
@media (max-width: 480px) {
    h1 {
        font-size: 1.5rem;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
    }

    button {
        font-size: 0.8rem;
        padding: 6px 12px;
    }
}
</style>

<body>
    <div class="container">
        <h1>Modifier le profil</h1>
        <?php if (isset($message)): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>
        <form method="post" action="profil.php">
            <label for="login">Nouveau nom d'utilisateur :</label>
            <input type="text" id="login" name="login" value="<?= htmlspecialchars($user['login']) ?>" required>

            <label for="password">Nouveau mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirmer le nouveau mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Mettre à jour</button>
        </form>
    </div>
</body>
</html>

