<?php

declare(strict_types=1);

use Kagirova\Hw6\EmailValidator;

require __DIR__ . '/../vendor/autoload.php';

$emails = [
    'hinoho27@gmail.com',
    'test@test.ru',
    '124'
];

$validator = new EmailValidator();

foreach ($emails as $email) {
    if (!$validator->validate($email)) {
        echo "Email " . $email . " is not valid\n";
    }
}
