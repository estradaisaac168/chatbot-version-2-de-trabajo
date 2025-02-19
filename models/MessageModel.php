<?php
require_once './config/database.php';

class MessageModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function getMessage()
    {
        $query = "SELECT * FROM questions ORDER BY id DESC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
