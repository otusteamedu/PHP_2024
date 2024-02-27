<?php

declare(strict_types=1);

use App\src\Validators\EmailValidator;

require '../../vendor/autoload.php';

$emails = [
    'test@mail.ru',
    'test1@yandex.ru',
    'test2@test.test.',
    'test3@test',
    'test4.com',
    'test5.com#@test.test',
    'test6@.com#@test.test',
];

foreach ($emails as $email) {
    try {
        $validator = new EmailValidator($email);
        echo $validator->validate() . '<br>';
    } catch (Exception $e) {
        echo $e->getMessage() . '<br>';
    }
}
