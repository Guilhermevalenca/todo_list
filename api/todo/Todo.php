<?php
class Todo
{
    public $conn;
    public function __construct(object $var = null) {
        $this->conn = $var;
    }
    public function getAllTodos() 
    {
        $response = [];
        $code = 0;

        $sql = 'SELECT * FROM TODO_DATA;';
        try{
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $response['todos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response['success'] = true;
            if(!empty($response['todos'])){
                $code = 200;
            }else {
                $code = 204;
            }
        }catch (PDOException $e) {
            $response['error'] = $e;
            $code = 204;
        }
        return [
            'response' => $response,
            'code' => $code
        ];
    }
    public function getTodo($id)
    {
        $response = [];
        $code = 0;

        $sql = 'SELECT * FROM TODO_DATA WHERE DATA_ID = :id;';
        try{
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $response['todos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response['success'] = true;
            if(!empty($response['todos'])){
                $code = 200;
            }else {
                $code = 204;
            }
        }catch (PDOException $e) {
            $response['error'] = $e;
            $code = 204;
        }
        return [
            'response' => $response,
            'code' => $code
        ];
    }
    public function createTodo($name, $responsible) 
    {
        $response = [];
        $code = 0;

        $sql = 'INSERT INTO TODO_DATA(DATA_NAME,DATA_RESPONSIBLE) VALUES (:name, :responsible);';
        try{
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':responsible',$responsible);
            $stmt->execute();
            $response['success'] = true;
            $code = 201;
        }catch(PDOException $e) {
            $response['error'] = $e;
            $code = 304;
        }
        return [
            'response' => $response,
            'code' => $code
        ];
    }
    public function updateTodo($name, $responsible, $id)
    {
        $response = [];
        $code = 0;

        $sql = 'UPDATE TODO_DATA SET DATA_NAME = :name, DATA_RESPONSIBLE = :responsible WHERE DATA_ID = :id;';
        try{
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':responsible',$responsible);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $response['success'] = true;
            $code = 200;
        }catch(PDOException $e) {
            $response['error'] = $e;
            $code = 304;
        }
        return [
            'response' => $response,
            'code' => $code
        ];
    }
    public function updateStatusTodo($status, $id)
    {
        $response = [];
        $code = 0;

        $sql = 'UPDATE TODO_DATA SET DATA_STATUS = :status WHERE DATA_ID = :id;';
        try{
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':status',$status);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $response['success'] = true;
            $code = 200;
        }catch(PDOException $e){
            $response['error'] = $e;
            $code = 304;
        }
        return [
            'response' => $response,
            'code' => $code
        ];
    }
    public function deleteTodo($id) 
    {
        $response = [];
        $code = 0;
        
        $sql = 'DELETE FROM TODO_DATA WHERE DATA_ID = :id;';
         
        try{
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $response['stmt'] = $stmt;
            $code = 200;
        }catch(PDOException $e) {
            $response['error'] = $e;
            $code = 304;
        }
        return [
            'response' => $response,
            'code' => $code
        ];
    }
}