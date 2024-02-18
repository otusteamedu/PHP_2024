<?php
$dbUser = 'root';
$dbPass = 'root';

try {
// подключаемся к серверу
    $conn = new \PDO("mysql:host=mysql_hw4;dbname=hw4", $dbUser, $dbPass);

// SQL-выражение для создания базы данных
    $sql = "CREATE TABLE staplers
        (
            id INT PRIMARY KEY AUTO_INCREMENT,
            input VARCHAR(255),
            is_valid BIT,
            message VARCHAR(255)
        )";

    echo $sql;
// выполняем SQL-выражение
    $conn->exec($sql);
    echo "Database has been created";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}

