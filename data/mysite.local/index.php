<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Apeskovatzkov\Hw4\StringValidator;

session_start();

try {
    StringValidator::validateBrackets($_POST['string'] ?? '');
    http_response_code(200);
    echo "Все хорошо\n";
} catch (Exception $e) {
    http_response_code($e->getCode());
    echo $e->getMessage() . "\n";
}
