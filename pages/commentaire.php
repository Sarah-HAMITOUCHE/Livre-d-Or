<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: connexion.php");
    exit();
}

require_once 'classes/Comment.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment']);
    if (!empty($comment)) {
        $commentObj = new Comment();
        $commentObj->addComment($comment, $_SESSION['user_id']);
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
    <link rel="stylesheet" href="../assets/style/styles.css">
    <link rel="stylesheet" href="../assets/style/commentaire.css">
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