<?php

require_once __DIR__ . '/vendor/autoload.php';

use EmailVerifier\EmailVerifierFacade;

// Список email для проверки
$emails = [
    'noster2@gmail.com',
    'invalid-email',
    'nonexistent@domain.com'
];

$verifier = new EmailVerifierFacade();
echo $verifier->verifyAndFormat($emails);
