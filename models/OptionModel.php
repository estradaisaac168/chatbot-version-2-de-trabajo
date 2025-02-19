<?php
require_once './config/database.php';

class OptionModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function getAll()
    {
        try {
            $query = "SELECT * FROM options ORDER BY id DESC";
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getAllNotNull()
    {
        try {
            $query = "SELECT * FROM options WHERE next_question IS NOT NULL ORDER BY id DESC";
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function getById($question_id)
    {
        try {
            $query = "SELECT * FROM options WHERE question_id = :question_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':question_id', $question_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function getAllIsNull()
    {
        try {
            $query = "SELECT * FROM options WHERE next_question IS NULL ORDER BY id DESC";
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function createOption($option)
    {

        try {

            $query = "INSERT INTO options (option_text, type_option, question_id, next_question) 
            VALUES (:option_text, :type_option, :question_id, :next_question)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':option_text', $option['txtOption']);
            $stmt->bindParam(':type_option', $option['ddType']);
            $stmt->bindParam(':question_id', $option['ddQuestion']);

            $question_next = $option['ddQuestionNext'];
            $stmt->bindParam(':next_question', $question_next, $question_next === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return ['error' => false, 'id' => $this->conn->lastInsertId()];

            } else {
                throw new Exception('Error al ejecutar la consulta');
            }

        } catch (Exception $e) {
            // En caso de error, se lanza una excepción
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
