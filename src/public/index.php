<?php

declare(strict_types=1);

try {
    $dbName = getenv('POSTGRES_DB');
    $user = getenv('POSTGRES_USER');
    $password = getenv('POSTGRES_PASSWORD');
    $dns = "pgsql:host=postgres;port=5432;dbname=$dbName;user=$user;password=$password;";
    $pdo = new PDO($dns, null, null, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => true,
    ]);
    $statement = $pdo->query('SELECT now() as current_time');
    echo $statement->fetch()['current_time'] . PHP_EOL;
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}
