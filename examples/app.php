<?php

declare(strict_types=1);

include __DIR__ . '/../vendor/autoload.php';

use Dsmolyaninov\Hw6\EmailVerifier;

$verifier = new EmailVerifier();
$emails = ["example@gmail.com", "invalid-email", "test@example.ru"];
$results = $verifier->verifyEmails($emails);
