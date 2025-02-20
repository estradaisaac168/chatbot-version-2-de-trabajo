<?php
require_once './config/database.php';

class DocumentModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function getById($id)
    {
        try {
            // $query = "SELECT * FROM documents WHERE id = :id";
            $query = "SELECT d.id, d.document_name, d.file_path, d.created_at, d.response_id, r.response_text, t.name
                        FROM documents d
                        INNER JOIN responses r 
                        ON d.response_id = r.id
                        INNER JOIN types_documents t  
                        ON r.type_response = t.id
                        WHERE d.id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function createDocument($document)
    {

        try {

            $query = "INSERT INTO documents (document_name, file_path, created_at, response_id) 
            VALUES (:document_name, :file_path, :created_at, :response_id)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':document_name', $document['name']);
            $stmt->bindParam(':file_path', $document['path']);
            $stmt->bindParam(':created_at', $document['createdAt']);
            $stmt->bindParam(':response_id', $document['responseId']);

            if ($stmt->execute()) {
                return ['error' => false, 'id' => intval($this->conn->lastInsertId())];
            } else {
                throw new Exception('Error al ejecutar la consulta');
            }
        } catch (Exception $e) {
            // En caso de error, se lanza una excepción
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
