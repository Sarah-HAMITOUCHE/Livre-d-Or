<?php
// Informations de connexion
$host = 'localhost';  // Serveur (change si nécessaire)
$dbname = 'livreor';  // Nom de ta base de données
$username = 'root';   // Utilisateur MySQL (par défaut "root" en local)
$password = '';       // Mot de passe (vide en local sous XAMPP)

// Connexion à la base avec PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
require_once 'database.php'; // Connexion à la base

// 🔍 Gestion de la recherche
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// 📄 Gestion de la pagination
$perPage = 5; // Nombre de commentaires par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $perPage;

// 🔄 Requête SQL avec filtre de recherche
if ($search) {
    $stmt = $conn->prepare("SELECT comment.*, user.login FROM comment 
                            JOIN user ON comment.id_user = user.id 
                            WHERE comment.comment LIKE ? 
                            ORDER BY date DESC 
                            LIMIT ?, ?");
    $stmt->execute(["%$search%", $start, $perPage]);
} else {
    $stmt = $conn->prepare("SELECT comment.*, user.login FROM comment 
                            JOIN user ON comment.id_user = user.id 
                            ORDER BY date DESC 
                            LIMIT ?, ?");
    $stmt->bindValue(1, $start, PDO::PARAM_INT);
    $stmt->bindValue(2, $perPage, PDO::PARAM_INT);
    $stmt->execute();
}

$comments = $stmt->fetchAll();

// 📊 Récupérer le nombre total de commentaires pour la pagination
$total = $conn->query("SELECT COUNT(*) FROM comment")->fetchColumn();
$pages = ceil($total / $perPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>Livre d'or</h1>

    <!-- 🔍 Formulaire de recherche -->

    <!-- ✍️ Bouton pour ajouter un commentaire si l'utilisateur est connecté -->
 

    <!-- 📝 Affichage des commentaires -->
    <?php if ($comments): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p><strong><?= htmlspecialchars($comment['login']) ?></strong> a écrit le <?= date('d/m/Y', strtotime($comment['date'])) ?> :</p>
                <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
    <?php endif; ?>

    <!-- 📄 Pagination -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a href="livre-or.php?page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>" 
               class="<?= ($i == $page) ? 'active' : '' ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>

</body>
</html>
