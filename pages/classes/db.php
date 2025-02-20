<?php
class DB {
    protected PDO $db;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=livreor", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Méthode pour obtenir la connexion PDO
    public function getConnection(): PDO {
        return $this->db;
    }
}
?>