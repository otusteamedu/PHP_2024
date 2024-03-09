<?php

declare(strict_types=1);

namespace AlexanderGladkov\EmailValidation;

class EmailValidator
{
    public function validate(string $email): bool
    {
        return
            $this->validateByRegExp($email) &&
            $this->validateByMx($email);
    }

    private function validateByRegExp(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function validateByMx(string $email): bool
    {
        return checkdnsrr(explode('@', $email)[1]);
    }
}
