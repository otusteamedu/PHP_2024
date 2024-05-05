<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Otus\Hw4\PostRequestValidator;

echo "Запрос обработал контейнер: {$_SERVER['HOSTNAME']}" . PHP_EOL;

try {
    $validator = new PostRequestValidator(
        $_SERVER["REQUEST_METHOD"] ?? '',
        $_POST['string'] ?? ''
    );

    http_response_code($validator->getResponseCode());
    echo $validator->getMessage();
} catch (Exception $exception) {
    http_response_code(400);
    echo $exception->getMessage() . PHP_EOL;
}
