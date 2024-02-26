<?php

declare(strict_types=1);

namespace Afilipov\Hw6;

use Generator;

class App
{
    public function run(): Generator
    {
        $emails = [
            'test@mail.ru',
            'invalid_email',
            'name@gmail.com',
            'test@sadsdf.org'
        ];

        $emailValidator = new EmailValidator();
        foreach ($emails as $email) {
            yield $email => $emailValidator->validate($email);
        }
    }
}
