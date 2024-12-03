<?php

declare(strict_types=1);

namespace App;

use PetrovaA\VerifyEmail\EmailVerifier;

class App
{
    public function run()
    {
        $checkedEmails = [
            'test@mail.ru' => false,
            'test@email.ru' => false
        ];

        foreach ($checkedEmails as $email => $isChecked) {
            $isChecked = EmailVerifier::verifyEmail(email: $email, checkDNS: true);
            $checkedEmails[$email] = $isChecked;
        }


        header('Content-type: application/json');
        echo json_encode($checkedEmails);
    }
}