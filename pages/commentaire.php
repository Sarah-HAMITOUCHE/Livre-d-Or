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

<form method="post">
    <textarea name="comment" required></textarea>
    <button type="submit" name="submit">Poster</button>
</form>
