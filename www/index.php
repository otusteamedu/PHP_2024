<?php

ini_set('display_errors', 'on');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'GET') {
    echo '<h2>Hello world! ' . date('Y-m-d h:i:s') . '</h2>';
    echo '<h1>Server ip address ' . $_SERVER['SERVER_ADDR'] . '</h1>';

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
}

$variableName = 'string';

if ($requestMethod == 'POST') {
    if (key_exists($variableName, $_POST)) {
        $string = $_POST[$variableName];

        if (empty($string)) {
            http_response_code(400);
            $message = 'Empty variable';
            throw new Exception($message, 400);
        } else {
            $result = cutOne($string);

            if (strlen($result) > 0) {
                http_response_code(400);
                $message = 'Parse error with ending string "' . var_export($result, true) . '"';
                throw new Exception($message, 400);
            }
        }
    }
}

function cutOne($string): string
{
    $stringTemp = $string;

    do {
        $stringTemp = removeTag($stringTemp);
    } while (hasTag($stringTemp));

    return $stringTemp;
}

function hasTag($string): bool
{
    return is_int(mb_strpos($string, '()'));
}

function removeTag($string): string
{
    return str_replace('()', '', $string);
}
