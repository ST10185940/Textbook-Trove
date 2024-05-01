<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "textbook_trove_group39";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}catch(PDOException $ex){
    echo "Connection error: " . $ex->getMessage();
}

?>