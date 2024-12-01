<?php

declare(strict_types=1);

$emails = [
    'asd@mail.com',
    'asd@mail.ru',
    'asd@maisafasfasfasfasfasfasfl.ru',
];

foreach ($emails as $email) {
    if (check_email($email)) {
        print "Email " . $email . " is valid \n";
    } else {
        print "Email " . $email . " is not valid \n";
    }
}

function check_email(string $email): bool
{
    $mailDomain = explode('@', $email)[1];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !checkdnsrr($mailDomain)) {
        return false;
    }
    return true;
}