<?php

require 'emailVerifier.php';

$emails = [
    'test@example.com',
    'invalid-email',
    'another.test@domain.com',
    'no.mx.record@nonexistentdomain.xyz'
];

$results = verifyEmailList($emails);

foreach ($results as $email => $isValid) {
    echo $email . ' - ' . ($isValid ? 'Valid' : 'Invalid') . PHP_EOL;
}
