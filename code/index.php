<?php

use AlexAgapitov\OtusComposerProject\ValidateEmail;

require __DIR__.'/vendor/autoload.php';

$emails = [
    'example@example.com',
    'example@.com',
    'example@example.',
    '3xample@example.com',
    'example@',
    'exampl"e@example.com',
    'example@php.php',
    ''
];

foreach ($emails AS $email) {
    echo "$email - ".(ValidateEmail::validate($email) ? 'verified' : 'not verified' ) ."<br>";
}