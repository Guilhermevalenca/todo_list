<?php
require '../conf/init.php';
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE");
require 'Todo.php';

$data = json_decode(file_get_contents('php://input'),true);

$result = [];

$todo = new Todo($conn);

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    if(!empty($_GET['id'])) {
        $result = $todo->getTodo($_GET['id']);
    }else {
        $result = $todo->getAllTodos();
    }

}else if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $result = $todo->createTodo($data['name'], $data['responsible']);
    
}else if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    
    $result = $todo->updateTodo($data['name'],$data['responsible'],$data['id']);

}else if($_SERVER['REQUEST_METHOD'] == 'PATCH') {

    $result = $todo->updateStatusTodo($data['status'],$data['id']);

}else if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    
    $todo->deleteTodo($data['id']);
}

http_response_code($result['code']);
header('Content-Type: application/json');
echo json_encode($result['response']);
