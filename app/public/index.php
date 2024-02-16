<?php

require_once '../vendor/autoload.php';

use AleksandrOrlov\Php2024\Validator;

echo "Контейнер nginx: {$_SERVER['HOSTNAME']}<br><br>";

try {
    Validator::validateRequest();
} catch (Exception $e) {
    http_response_code(400);
    echo $e->getMessage();
}
