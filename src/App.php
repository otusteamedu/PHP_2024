<?php

namespace AKornienko\Php2024;

use AKornienko\Php2024\EmailValidation\Validator;

class App
{
    private array $emails = [
        '1@gmail.com',
        '1@1.com',
        '1@gmail',
        '1@gmail.',
        '@gmail.com',
        'gmail.com',
        '1',
    ];

    public function run(): \Generator
    {

        foreach ($this->emails as $email) {
            if (Validator::validate($email)) {
                $message = $email . " is valid";
            } else {
                $message = $email . " is invalid";
            }
            yield $message;
        }
    }
}
