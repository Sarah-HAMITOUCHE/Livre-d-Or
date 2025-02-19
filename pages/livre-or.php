<?php
/*connexion a la base de donnees*/
session_start();
if (isset($_SESSION['user'])) {
    echo '<a href="profil.php" class="button">Mon Profil</a>';
}
require_once 'database.php';
$conn = new PDO("mysql:host=localhost;dbname=livreor", "root", "");

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
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Lucida Calligraphy', cursive;
    
}

/* Style du corps de la page */
body {
    background: url('../assets/photos/fleurs blanches nette et belles.png') no-repeat center center;
    background-size: cover;
    text-align: center;
    padding-top: 20px;
    color: white;
    min-height: 100vh;
}

/* Conteneur principal */
.container {
    max-width: 800px;
    margin: auto;
    padding: 20px;
    background: rgba(194, 121, 4, 0.6);
    border-radius: 10px;
}

/* Titre principal */
h1 {
   font-size: 4rem;
   border-radius: 20px;
    font-family: 'Lucida Calligraphy', cursive;
    margin-bottom: 20px;
    text-shadow: 2px 2px 5px rgba(31, 32, 29, 0.7);
}

/* Formulaire de recherche */
.search-form {
    
    font-family: 'Lucida Calligraphy', cursive;
    margin-bottom: 20px;
}

.search-form input[type="text"] {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #f1dddd;
    width: 70%;
    font-size: 1rem;
    margin-right: 10px;
}

.search-form button {
    background-color:rgb(243, 224, 230);
    color: rgb(0, 0, 0);
    background: rgba(120, 177, 29, 0.99);
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
}

.search-form button:hover {
    background-color:rgb(255, 255, 255);
}

/* Bouton Ajouter un commentaire */
.button {
    display: inline-block;
    text-decoration: none;
    font-size: 1.5rem;
    color:rgb(8, 8, 8);
    background:rgb(125, 170, 54);
    padding: 10px 20px;
    border-radius: 4px;
    transition: background 0.3s ease;
    margin-bottom: 20px;
}

.button:hover {
    background: #f0eceb;
    color: #000;
}

/* Style des commentaires */
.comment {
    background: rgb(15, 14, 12);
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 5px;
    text-align: left;
    background-color: rgba(242, 243, 242, 0.4);
}

.comment p {
    margin-bottom: 10px;
}

.comment strong {
    color:rgba(102, 77, 2, 0.77);
}

/* Pagination */
.pagination {
    margin-top: 20px;
}

.pagination a {
    text-decoration: none;
    font-size: 1rem;
    color: #d1d171;
    background: #a39449;
    padding: 10px 15px;
    border-radius: 4px;
    transition: background 0.3s ease;
    margin: 0 5px;
}

.pagination a:hover{

}
@media (max-width: 768px) {
    .container {
        padding: 10px;
    }

    h1 {
        font-size: 3rem;
    }

    .search-form input[type="text"] {
        width: 100%;
        margin-bottom: 10px;
    }

    .search-form button {
        width: 100%;
    }

    .button {
        font-size: 1.2rem;
        padding: 8px 16px;
    }

    .comment {
        padding: 10px;
    }
}
@media (max-width: 480px) {
    h1 {
        font-size: 2rem;
    }

    .button {
        font-size: 1rem;
        padding: 6px 12px;
    }

    .comment {
        padding: 8px;
    }
}
</style>
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
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <p><strong><?= htmlspecialchars($comment['login']) ?></strong> a écrit le <?= date('d/m/Y', strtotime($comment['date'])) ?> :</p>
                    <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-comments">Aucun commentaire.</p>
        <?php endif; ?>
    </div>
</body>
</html>