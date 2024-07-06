<?php

ini_set('display_errors', 'on');

echo '<h2>Hello world! ' . date('Y-m-d h:i:s') . '</h2>';
echo '<h1>Server ip address '. $_SERVER['SERVER_ADDR'].'</h1>';

// check mysql
try {
    $dsn = 'mysql:host=' . getenv('MYSQL_HOST') . ';';
    $dsn .= 'dbname=' . getenv('MYSQL_DATABASE');

    $pdo = new PDO(
        $dsn,
        getenv('MYSQL_USER'),
        getenv('MYSQL_PASSWORD')
    );
    echo 'Database connection: successful</br>';
} catch (\Throwable $e) {
    echo 'Database connection: error. ' . $e->getMessage() . '</br>';
}

phpinfo();
