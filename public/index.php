<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use AShutov\Hw6\EmailValidator;

try {
    $filePath = 'emails.txt';
    $app = new EmailValidator();
    echo $app->run($filePath);
} catch (Throwable $e) {
    echo $e->getMessage();
}
