<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Dsergei\Hw4\ValidatorPostRequest;
use Dsergei\Hw4\CheckerString;
use Dsergei\Hw4\CheckerBracket;

echo "Запрос обработал контейнер: {$_SERVER['HOSTNAME']}" . PHP_EOL;

try {
    $validator = new ValidatorPostRequest(
        $_SERVER["REQUEST_METHOD"] ?? '',
        $_POST['string'] ?? ''
    );
    $checkerString = new CheckerString();
    $validator->validate($checkerString);

    $checkerBracket = new CheckerBracket();
    $validator->validate($checkerBracket);
} catch (Exception $exception) {
    http_response_code(400);
    echo $exception->getMessage();
}
