<?php
// Informations de connexion
$host = 'localhost';
$dbname = 'livreor';
$username = 'root';
$password = '';

// Connexion à la base avec PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Gestion de la recherche
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Gestion de la pagination
$perPage = 5; // Nombre de commentaires par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $perPage;

// Validation des paramètres de pagination
if (!is_int($start) || !is_int($perPage)) {
    die("Paramètres de pagination invalides.");
}
$stmt = $conn->prepare("SELECT comment.*, user.login FROM comment JOIN user ON comment.id_user = user.id ORDER BY date DESC LIMIT :start, :perPage");
$stmt->bindParam(":start", $start, PDO::PARAM_INT);
$stmt->bindParam(":perPage", $perPage, PDO::PARAM_INT);

// Construction de la requête SQL
$sql = "SELECT comment.*, user.login FROM comment 
        JOIN user ON comment.id_user = user.id ";

if ($search) {
    $sql .= "WHERE comment.comment LIKE :search ";
}

$sql .= "ORDER BY date DESC 
         LIMIT $start, $perPage";

$stmt = $conn->prepare($sql);

// Liaison des paramètres de recherche si nécessaire
if ($search) {
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
}

$stmt->execute();
$comments = $stmt->fetchAll();

// Récupérer le nombre total de commentaires pour la pagination
$total = $conn->query("SELECT COUNT(*) FROM comment")->fetchColumn();
$pages = ceil($total / $perPage);
?>

