<?php

declare(strict_types=1);


namespace Main;


use Main\Validators\EmailValidator;

class EmailTest
{
    protected $emailTestList = [
        'ej-ykz@zombo.com',
        'ww.rzx@weirdness.net',
        'znv+sw@alien.org',
        'jvwdlv@fantasy.land',
        'ftotg!b@cryptic.world',
        123,
        true,
        [1, 2, 4]
    ];

    public function runTest(): void
    {
        foreach ($this->emailTestList as $email) {
            $validator = new EmailValidator($email);
            if ($validator->validate()) {
                echo strval($email) . " - Валидный <br>";
            } else {
                echo (is_scalar($email) ? strval($email) : gettype($email)) . " - Ошибка: " . $validator->getErrorMessage() . "<br>";
            }
        }
    }
}