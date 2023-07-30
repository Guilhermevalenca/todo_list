<?php
ob_start();
require 'bootstrap.php';
ob_end_clean();

$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$dbname = $_ENV['DB_NAME'];

$dns = "mysql:host=$host:$port;dbname=$dbname";

try {
    $conn = new PDO($dns, $username, $password);
    //echo 'true';
} catch (PDOException $e) {
    //var_dump($e);
    http_response_code(500);
    exit();
}
