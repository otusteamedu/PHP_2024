<?php
$dbUser = 'root';
$dbPass = 'root';

try {
// подключаемся к серверу
    $conn = new PDO("mysql:host=mysql_hw4", $dbUser, $dbPass);

// SQL-выражение для создания базы данных
    $sql = "CREATE DATABASE hw4";
// выполняем SQL-выражение
    $conn->exec($sql);
    echo "Database \"hw4\" has been created";
}
catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}

?>