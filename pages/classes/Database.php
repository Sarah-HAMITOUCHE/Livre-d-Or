<?php
class Database
{
    private $host    = 'localhost';
    private $name    = 'livreor';
    private $user    = 'root';
    private $pass    = '';
    private $connexion;

    function __construct($host = null, $name = null, $user = null, $pass = null)
    {
        if ($host != null) {
            $this->host = $host;
            $this->name = $name;
            $this->user = $user;
            $this->pass = $pass;
        }
        try {
            $this->connexion = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->name,
                $this->user,
                $this->pass,
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
                )
            );
        } catch (PDOException $e) {
            echo 'Erreur : Impossible de se connecter à la BDD !';
            die();
        }
    }

    public function query($sql, $data = array())
    {
        $statement = $this->connexion->prepare($sql);
        $statement->execute($data);
        return $statement;
    }
    public function insert($sql, $data = array())
    {

        $statement = $this->connexion->prepare($sql);
        $statement->execute($data);
    }

    
    public function lastInsertId()
    {
        return $this->connexion->lastInsertId();
    }
}
$db = new Database();

