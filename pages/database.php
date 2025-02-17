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
echo "Connexion réussie à la base de données.";
?>
