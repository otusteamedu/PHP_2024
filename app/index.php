<?php

//phpinfo();

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
];

try {
    $pdo = new PDO(
        getenv('MYSQL_DSN'),
        getenv('MYSQL_USER'),
        getenv('MYSQL_PASSWORD'),
        $options
    );
    echo "Соединение установлено успешно!";
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Дальнейшая работа с базой данных...

// Закрытие соединения (если оно больше не нужно)
$pdo = null;