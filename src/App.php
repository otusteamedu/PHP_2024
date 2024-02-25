<?php

declare(strict_types=1);

namespace Afilipov\Hw6;

class App
{
    public function run(): void
    {
        $emails = [
            'test@mail.ru',
            'invalid_email',
            'name@gmail.com',
            'test@sadsdf.org'
        ];

        $emailValidator = new EmailValidator();
        foreach ($emails as $email) {
            if ($emailValidator->validate($email)) {
                echo "$email - валидный.<br/>";
            } else {
                echo "$email - не валидный.<br/>";
            }
        }
    }
}
