<?php

declare(strict_types=1);

namespace AlexanderGladkov\EmailValidation;

class Application
{
    public function run(array $emails): array
    {
        $emailValidator = new EmailValidator();
        $errors = [];
        foreach ($emails as $email) {
            if (!$emailValidator->validate($email)) {
                $errors [] = "$email - невалидный email<br>";
            }
        }

        return $errors;
    }
}
