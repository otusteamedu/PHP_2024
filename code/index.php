<?php
require_once __DIR__ . '/vendor/autoload.php';

use Ekonyaeva\Otus\EmailValidate;

$emails = [
    'example@example.com',
    'user@.com',
    'test.email+alex@leetcode.com',
    'user.name@domain.co.uk',
    'username@domain..com',
    'example@.com',
    '@example.com',
    'user@subdomain.domain.com',
    'first_last@domain.org',
    'user@domain.corporate',
    'user@domain.a1',
    'name123@numbers.com',
    '"user@name".com',
    'user@domain.com.',
    'email@domain.name',
    'user@domain..com',
    'user@-domain.com',
    'email@domain.c',
    'email@domain.museum',
    'test@.domain.com',
];

$results = EmailValidate::validateArray($emails);
EmailValidate::printValidationResults($emails, $results);

