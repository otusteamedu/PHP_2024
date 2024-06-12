<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Otus\Hw4\PostRequestValidator;
use Otus\Hw4\ResponseHelper;

echo "Запрос обработал контейнер: {$_SERVER['HOSTNAME']}" . PHP_EOL;

try {
    $validator = new PostRequestValidator();
    $responseCode = $validator->getResponseCode();
    $message = $validator->getMessage();
} catch (Exception $exception) {
    $responseCode = 400;
    $message = $exception->getMessage() . PHP_EOL;
}

ResponseHelper::sendResponse($responseCode);
echo $message;
