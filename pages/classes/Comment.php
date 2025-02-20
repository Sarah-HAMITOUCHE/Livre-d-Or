<?php
require_once __DIR__ . "/Database.php"; // Ensure the correct path

class Comment
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addComment($comment, $id_user)
    {
        $sql = "INSERT INTO comment (comment, id_user, date) VALUES (:comment, :id_user, NOW())";
        $data = array(':comment' => $comment, ':id_user' => $id_user);
        $this->db->insert($sql, $data);
        return $this->db->lastInsertId();
    }

    public function getCommentsByUserId($id_user)
    {
        $sql = "SELECT * FROM comment WHERE id_user = :id_user ORDER BY date DESC";
        $data = array(':id_user' => $id_user);
        $result = $this->db->query($sql, $data);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllComments()
    {
        $sql = "SELECT * FROM comment ORDER BY date DESC";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}