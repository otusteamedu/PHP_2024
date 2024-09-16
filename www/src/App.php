<?php

namespace Ahar\Hw6;

use Generator;

class App
{
    public function run(array $emails): Generator
    {
        $emailValidator = new EmailValidator();
        foreach ($emails as $email) {
            yield $email => $emailValidator->validate($email);
        }
    }
}
