<?php

if (empty(getenv('PGSQL_USERNAME')) || empty(getenv('PGSQL_PASSWORD')) || empty(getenv('PGSQL_DATABASE'))) {
    exit("not enough env variables" . PHP_EOL);
}

$dsnStr = sprintf(
    "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
    'postgresql',
    '5432',
    getenv('PGSQL_DATABASE'),
    getenv('PGSQL_USERNAME'),
    getenv('PGSQL_PASSWORD')
);

$dbh = new PDO($dsnStr);
