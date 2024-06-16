<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AlexanderGladkov\EmailValidation\Application;

try {
    $testEmails = [
        'test@gmail.com',
        'test1@mail.ru',
        'test@yandex.ru',
        'test@gmail.org',
        'test-gmail.com',
        'test.test.test@gmail.com',
        'test.test.test@mail.ru',
        'test@gmial',
    ];

    $errors = (new Application())->run($testEmails);
    foreach ($errors as $error) {
        echo $error . PHP_EOL;
    }
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}
