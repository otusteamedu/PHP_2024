<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\App;

// Пример использования
$emailsToCheck = [
    'validemail@example.com',
    'invalidemail.com',
    'no-domain@invalid-domain',
    'example@google.com',
];

$app = new App();
$result = $app->validateEmails($emailsToCheck);

print_r($result);
