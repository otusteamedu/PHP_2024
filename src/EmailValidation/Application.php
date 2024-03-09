<?php

declare(strict_types=1);

namespace AlexanderGladkov\EmailValidation;

class Application
{
    public function run(): void
    {
        $emails = [
            'test@gmail.com',
            'test1@mail.ru',
            'test@yandex.ru',
            'test@gmail.org',
            'test-gmail.com',
            'test.test.test@gmail.com',
            'test.test.test@mail.ru',
            'test@gmial',
        ];

        $emailValidator = new EmailValidator();
        foreach ($emails as $email) {
            if (!$emailValidator->validate($email)) {
                echo "$email - невалидный email<br>" . PHP_EOL;
            }
        }
    }
}
