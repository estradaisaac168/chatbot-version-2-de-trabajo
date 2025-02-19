<?php
require_once './config/database.php';

class QuestionModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function getAll()
    {
        $query = "SELECT * FROM questions ORDER BY id DESC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAllNotNull()
    {
        try {
            $query = "SELECT * FROM questions WHERE parent_question IS NOT NULL ORDER BY id";
            // $query = "SELECT * FROM questions WHERE parent_question IS NULL";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function getById($id)
    {
        try {
            $query = "SELECT * FROM questions WHERE id = :id";
            // $query = "SELECT * FROM questions WHERE parent_question IS NULL";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }



    public function saveQuestion($question)
    {

        try {

            $query = "INSERT INTO questions (question_text, parent_question, is_root) VALUES (:question_text, :parent_question, :is_root)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':question_text', $question['txtQuestion']);

            $parent_question = $question['ddParentQuestion'];
            $stmt->bindParam(':parent_question', $parent_question, $parent_question === null ? PDO::PARAM_NULL : PDO::PARAM_INT);

            $is_root = $question['chkIsRoot'];
            $stmt->bindParam(':is_root', $is_root, PDO::PARAM_INT);


            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception('Error al ejecutar la consulta');
            }
        } catch (Exception $e) {
            // En caso de error, se lanza una excepción
            return ['error' => false, 'message' => $e->getMessage() . "isa"];
        }
    }
}
