<?php
// connexion à la base de données
require_once 'database.php';
session_start();

// Vérifier si l'utilisateur est un administrateur
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: connexion.php");
    exit();
}

// Récupérer les commentaires en attente
$stmt = $conn->prepare("SELECT comment.id, comment.comment, user.login FROM comment JOIN user ON comment.id_user = user.id WHERE comment.statut = 'en_attente'");
$stmt->execute();
$comments = $stmt->fetchAll();

if (isset($_POST['action'])) {
    $commentId = $_POST['comment_id'];
    if ($_POST['action'] == 'approuver') {
        $updateStmt = $conn->prepare("UPDATE comment SET statut = 'approuvé' WHERE id = ?");
        $updateStmt->execute([$commentId]);
    } elseif ($_POST['action'] == 'supprimer') {
        $deleteStmt = $conn->prepare("DELETE FROM comment WHERE id = ?");
        $deleteStmt->execute([$commentId]);
    }
    header("Location: admin.php");
    exit();
}
?>

<h1>Modération des commentaires</h1>
<?php foreach ($comments as $comment): ?>
    <div>
        <p><strong><?= htmlspecialchars($comment['login']) ?></strong> a écrit :</p>
        <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
        <form method="post">
            <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
            <button type="submit" name="action" value="approuver">Approuver</button>
            <button type="submit" name="action" value="supprimer">Supprimer</button>
        </form>
    </div>
<?php endforeach; ?>
