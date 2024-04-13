<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$dsn = sprintf(
    "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
    'postgresql',
    '5432',
    'hukimato',
    'hukimato',
    'hukimato',
);

$pdo = new PDO($dsn);

$statements = <<< SQL
CREATE TABLE IF NOT EXISTS users (
    username varchar(255) NOT NULL PRIMARY KEY,
    email varchar(255)
);

CREATE TABLE IF NOT EXISTS posts (
    id SERIAL NOT NULL PRIMARY KEY,
    title varchar(255) NOT NULL,
    content varchar(255) NOT NULL,
    user_username varchar(255) NOT NULL REFERENCES users(username)
);

CREATE TABLE IF NOT EXISTS user_to_friends (
    username varchar(255) NOT NULL REFERENCES users(username),
    friend_username varchar(255) NOT NULL REFERENCES users(username)
);
SQL;

$pdo->exec($statements);
