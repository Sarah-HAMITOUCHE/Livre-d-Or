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

