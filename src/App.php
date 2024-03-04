<?php

namespace AKornienko\Php2024;

use AKornienko\Php2024\EmailValidation\Validator;

class App
{
    public function run(array $emails): \Generator
    {
        foreach ($emails as $email) {
            if (Validator::validate($email)) {
                $message = $email . " is valid";
            } else {
                $message = $email . " is invalid";
            }
            yield $message;
        }
    }
}
