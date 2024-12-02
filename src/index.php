<?php

use PetrovaA\VerifyEmail\EmailVerifier;

require './vendor/autoload.php';

$checkedEmails = [
    'test@mail.ru' => false,
    'test@email.ru' => false
];

foreach ($checkedEmails as $email => $isChecked) {
    $isChecked = EmailVerifier::verifyEmail(email: $email, checkDNS: true);
    $checkedEmails[$email] = $isChecked;
}

print_r($checkedEmails);
