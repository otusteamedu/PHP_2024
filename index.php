<?php

require_once __DIR__ . '/vendor/autoload.php';

use EmailVerifier\EmailChecker;
use EmailVerifier\ResultFormatter;

// Список email для проверки
$emails = [
    'noster2@gmail.com',
    'invalid-email',
    'nonexistent@domain.com'
];

$checker = new EmailChecker();
$formatter = new ResultFormatter();

$results = $checker->checkEmails($emails);

echo $formatter->format($results);
