<?php
require_once __DIR__ . "/Database.php"; // Ensure the correct path

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function login($login, $password)
    {
        $sql = "SELECT * FROM user WHERE login = :login";
        $data = array(':login' => $login);
        $result = $this->db->query($sql, $data);
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }

    public function register($login, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (login, password) VALUES (:login, :password)";
        $data = array(':login' => $login, ':password' => $hashedPassword);
        $this->db->insert($sql, $data);
        return $this->db->lastInsertId();
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM user WHERE id = :id";
        $data = array(':id' => $id);
        $result = $this->db->query($sql, $data);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $login, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET login = :login, password = :password WHERE id = :id";
        $data = array(':login' => $login, ':password' => $hashedPassword, ':id' => $id);
        $this->db->query($sql, $data);
    }
}