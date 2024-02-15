<?php

require_once '../vendor/autoload.php';

use AleksandrOrlov\Php2024\Validator;

if (!empty($_POST['string'])) {
    try {
        $result = Validator::validate($_POST['string']);
        http_response_code(200);
        echo $result;
    } catch (Exception $e) {
        http_response_code(400);
        echo $e->getMessage();
    }
}

echo "Контейнер nginx: {$_SERVER['HOSTNAME']}<br><br>";
