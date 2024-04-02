<?php

declare(strict_types=1);

use AleksandrOrlov\Php2024\Mappers\HallRowsMapper;

require_once __DIR__ . '/vendor/autoload.php';

try {
    $dsn = "pgsql:host=host.docker.internal;port=5432;dbname=theater;";
    $pdo = new PDO($dsn, 'postgres', 'postgres', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $hallRowsMapper = new HallRowsMapper($pdo);
    $hallRows = $hallRowsMapper->findAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}
