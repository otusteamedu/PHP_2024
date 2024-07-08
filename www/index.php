<?php

ini_set('display_errors', 'on');

include './common/Parser.php';
include './common/BaseException.php';

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

$variable = 'string'; // variable name

if ($requestMethod == 'POST') {
    try {
        if (key_exists($variable, $_POST)) {
            $string = $_POST[$variable];

            if (empty($string)) {
                throw BaseException::error('Empty variable');
            } else {
                $result = (new Parser())->setString($string)->process();

                if (strlen($result) > 0) {
                    throw BaseException::error('Invalid string value');
                } else {
                    echo 'Variable parsed well';
                }
            }
        }
    } catch (BaseException $e) {
        echo $e->getMessage();
    } catch (Exception $e) {
        throw $e;
    }
}