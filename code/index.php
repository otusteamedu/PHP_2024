<?php

echo "<pre>";

try {
    $db = getenv("DB_NAME");
    $user = getenv("DB_USER");
    $pass = getenv("DB_PASSWORD");
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO("mysql:host=mysql;dbname=$db", $user, $pass, $opt);
    $stmt = $pdo->query('SHOW DATABASES;');

    while ($row = $stmt->fetch()) {
        print_r($row);
    }
} catch (\Throwable $e) {
    print_r($e->getMessage());
}

echo "</pre>";
