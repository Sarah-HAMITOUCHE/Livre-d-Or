<?php
/*connexion a la base de donnees*/
require_once 'database.php';
$conn = new PDO("mysql:host=localhost;dbname=livreor", "root", "");

$stmt = $conn->query("SELECT comment.*, user.login FROM comment JOIN user ON comment.id_user = user.id ORDER BY date DESC");
$comments = $stmt->fetchAll();

/*pagination*/
$perPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $perPage;

$stmt = $conn->prepare("SELECT comment.*, user.login FROM comment JOIN user ON comment.id_user = user.id ORDER BY date DESC LIMIT ?, ?");
$stmt->bindValue(1, $start, PDO::PARAM_INT);
$stmt->bindValue(2, $perPage, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll();

// Récupérer le nombre total de commentaires
$total = $conn->query("SELECT COUNT(*) FROM comment")->fetchColumn();
$pages = ceil($total / $perPage);

for ($i = 1; $i <= $pages; $i++) {
    echo "<a href='livre-or.php?page=$i'>$i</a> ";
}

//logique du formulaire de recherche //
$search = isset($_GET['search']) ? $_GET['search'] : '';
$stmt = $conn->prepare("SELECT comment.*, user.login FROM comment JOIN user ON comment.id_user = user.id WHERE comment.comment LIKE ? ORDER BY date DESC");
$stmt->execute(["%$search%"]);
$comments = $stmt->fetchAll();

?>

<!--partie html -->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php if (isset($_SESSION['user'])): ?>
        <a href="commentaire.php">Ajouter un commentaire</a>
    <?php endif; ?>

    <?php foreach ($comments as $comment): ?>
        <p><strong><?= $comment['login'] ?></strong> a écrit le <?= date('d/m/Y', strtotime($comment['date'])) ?> :</p>
        <p><?= htmlspecialchars($comment['comment']) ?></p>
        <hr>
    <?php endforeach; ?>
</body>
</html>
