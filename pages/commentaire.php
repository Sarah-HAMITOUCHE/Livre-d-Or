<?php
//connexion base de donnees 
require_once 'database.php';

session_start();
$conn = new PDO("mysql:host=localhost;dbname=livreor", "root", "");

if (!isset($_SESSION['user'])) {
    header("Location: connexion.php");
    exit();
}

if (isset($_POST['submit'])) {
    $comment = htmlspecialchars($_POST['comment']);
    $stmt = $conn->prepare("INSERT INTO comment (comment, id_user) VALUES (?, ?)");
    $stmt->execute([$comment, $_SESSION['user']['id']]);
    header("Location: livre-or.php");
}
?>

<?php

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment']);
    if (!empty($comment)) {
        // Préparer et exécuter la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO comment (comment, id_user, date) VALUES (?, ?, 'en_attente')");
        $stmt->execute([$comment, $_SESSION['user']['id']]);
        // Rediriger vers la page affichant les commentaires après l'ajout
        header("Location: livre-or.php");
        exit();
    } else {
        $error = "Le commentaire ne peut pas être vide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Commentaire</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un Commentaire</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post">
            <textarea name="comment" placeholder="Votre commentaire..." required></textarea>
            <button type="submit">Poster</button>
        </form>
    </div>
</body>
</html>
