<?php
require_once './config/database.php';

class ResponseModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function getAll()
    {
        try {
            $query = "SELECT * FROM responses ORDER BY id DESC";
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getById($id)
    {
        try {
            $query = "SELECT * FROM responses WHERE parent_response = :parent_response";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':parent_response', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    // public function getById($id)
    // {
    //     try {
    //         $query = "SELECT * FROM responses WHERE id = :id";
    //         $stmt = $this->conn->prepare($query);
    //         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    //         $stmt->execute();
    //         return $stmt->fetch(PDO::FETCH_OBJ);
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //         return false;
    //     }
    // }

    public function getAllById($question_id)
    {
        try {
            $query = "SELECT * FROM responses WHERE question_id = :question_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':question_id', $question_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function saveResponse($response)
    {

        try {

            $query = "INSERT INTO responses (response_text, option_id, next_question) 
          VALUES (:response_text, :option_id, :next_question)";

            $stmt = $this->conn->prepare($query);

            // Vincular los parámetros con sus respectivos valores
            $stmt->bindParam(':response_text', $response['txtResponseArea']);
            $stmt->bindParam(':option_id', $response['ddOption']);
            $next_question = $response['ddQuestionNext'];

            // Vincular el parámetro para `next_question`, verificando si es null
            $stmt->bindParam(':next_question', $next_question, $next_question === null ? PDO::PARAM_NULL : PDO::PARAM_INT);


            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception('Error al ejecutar la consulta');
            }
        } catch (Exception $e) {
            // En caso de error, se lanza una excepción
            return ['error' => false, 'message' => $e->getMessage()];
        }
    }
}
