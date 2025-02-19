<?php
/*connexion a la base de donnees*/
session_start();
if (isset($_SESSION['user'])) {
    echo '<a href="profil.php" class="button">Mon Profil</a>';
}
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
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="livre-or.css">
</head>
<body>
    <div class="container">
        <h1>Livre d'Or</h1>
        <!-- 🔍 Barre de recherche -->
        <form method="get" class="search-form">
            <input type="text" name="search" placeholder="Rechercher un commentaire...">
            <button type="submit">Chercher</button>
        </form>
        <div>
    <?php if (isset($_SESSION['user'])): ?>
    <a href="commentaire.php" class="button">Ajouter un commentaire</a>
    <?php endif; ?>
    </div>

        <!-- 📝 Affichage des commentaires -->
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p><strong><?= htmlspecialchars($comment['login']) ?></strong> a écrit le <?= date('d/m/Y', strtotime($comment['date'])) ?> :</p>
                <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>

        <!-- 📝 Affichage des commentaires -->
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <p><strong><?= htmlspecialchars($comment['login']) ?></strong> a écrit le 
                        <?= date('d/m/Y', strtotime($comment['date'])) ?> :</p>
                    <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <p class="no-comments">Aucun commentaire pour le moment.</p>
        <?php endif; ?>

    </div>



</body>
</html>
