<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Apeskovatzkov\Hw4\StringValidator;

session_start();

try {
    StringValidator::validateBrackets($_POST['string'] ?? '');
    echo "Все хорошо\n";
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
