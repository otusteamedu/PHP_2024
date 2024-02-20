<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use AleksandrOrlov\Php2024\EmailValidator;

$emails = [
  'amanbs@mail.ru',
  'akjdbajwbd@gmail.com',
  'akjwbdkjab@kjakjdba@jabd',
  'test111@test.ru',
];
$validator = new EmailValidator();

foreach ($emails as $email) {
    if (!$validator->validate($email)) {
         echo 'Email: ' . $email . ' некорректный' . '<br>';
    }
}
