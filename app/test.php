<?php

declare(strict_types=1);

use ERybkin\EmailValidator\EmailValidator;
use ERybkin\EmailValidator\Validation\DnsMxRecordValidation;
use ERybkin\EmailValidator\Validation\EmailValidation;
use ERybkin\EmailValidator\ValidationPool;

require __DIR__ . '/vendor/autoload.php';

$pool = new ValidationPool([
    new EmailValidation(),
    new DnsMxRecordValidation(),
]);

$validator = new EmailValidator($pool);

$emails = [
    'test@example.com.', // not valid
    'test@noname.com', // not valid
    'test@undefined-domain.com', // not valid
    'test@yandex.ru', // valid
    'test@gmail.com', // valid
];

var_dump($validator->validateMany($emails));
