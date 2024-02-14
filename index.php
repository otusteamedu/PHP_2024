<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['POSTGRES_DB_HOST'] ?? null;
$db   = $_ENV['POSTGRES_DB_NAME'] ?? null;
$dbPort = $_ENV['POSTGRES_PORT'] ?? null;
$user = $_ENV['POSTGRES_USER'] ?? null;
$pass = $_ENV['POSTGRES_PASSWORD'] ?? null;

$dsn = "pgsql:host=$host;port=$dbPort;dbname=$db;user=$user;password=$pass";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->exec("SET client_encoding TO 'UTF8';");
    echo "Соединение с базой данных установлено успешно.";
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

phpinfo();
