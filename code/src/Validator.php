<?php

declare(strict_types=1);

namespace ASyrovatkin\Hw5;

class Validator
{
    public function checkEmails(string $email): bool
    {
        $mailDomain = explode('@', $email)[1];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !checkdnsrr($mailDomain)) {
            return false;
        }
        return true;
    }

}