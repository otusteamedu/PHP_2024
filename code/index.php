<?php

declare(strict_types=1);
require 'vendor/autoload.php';

use Otus\Hw4\RequestValidator;

echo "Запрос обработал контейнер: {$_SERVER['HOSTNAME']}" . PHP_EOL;

$string = $_POST['string'] ?? '';

$requestValidator = new RequestValidator();
$bracketsCounter = $requestValidator->validate($string);

if (!empty($string) && $bracketsCounter === 0) {
    http_response_code(200);
    header('Content-Type: text/plain; charset=utf-8');
    return "Строка корректна.";
} else {
    http_response_code(400);
    header('Content-Type: text/plain; charset=utf-8');
    return "Строка некорректна.";
}
