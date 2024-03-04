<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$validEmails = [
    "email@example.com",
    "firstname.lastname@example.com",
    "email@subdomain.example.com",
    "firstname+lastname@example.com",
    "email@123.123.123.123",
    "email@[123.123.123.123]",
    "\"email\"@example.com",
    "1234567890@example.com",
    "email@example-one.com",
    "_______@example.com",
    "email@example.name",
    "email@example.museum",
    "email@example.co.jp",
    "firstname-lastname@example.com",
];

$invalidEmails = [
    "plainaddress",
    "#@%^%#$@#$@#.com",
    "@example.com",
    "Joe Smith <email@example.com>",
    "email.example.com",
    "email@example@example.com",
    ".email@example.com",
    "email.@example.com",
    "email..email@example.com",
    "あいうえお@example.com",
    "email@example.com (Joe Smith)",
    "email@example",
    "email@-example.com",
    "email@example.web",
    "email@111.222.333.44444",
    "email@example..com",
    "Abc..123@example.com",
];

echo "Проверка валидных" . PHP_EOL;
foreach(\Hukimato\EmailValidator\EmailValidator::validateArray($validEmails) as $key => $result) {
    if (!$result) {
        echo $validEmails[$key] . " неверно определён как невалдиный" . PHP_EOL;
    }
}

echo "Проверка невалидных" . PHP_EOL;
foreach(\Hukimato\EmailValidator\EmailValidator::validateArray($invalidEmails) as $key => $result) {
    if ($result) {
        echo $validEmails[$key] . " неверно определён как валдиный" . PHP_EOL;
    }
}
