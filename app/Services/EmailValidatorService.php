<?php

namespace App\Services;

class EmailValidatorService
{
    protected string $pattern = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/';

    public function validate(array $emails): array
    {
        $result = [];

        foreach ($emails as $email) {
            $result[$email] = $this->validateEmail($email);
        }

        return $result;
    }

    protected function validateEmail(string $email): bool
    {
        return $this->validateRegex($email) && $this->validateDns($email);
    }

    protected function validateRegex(string $email): bool
    {
        return preg_match($this->pattern, $email);
    }

    protected function validateDns(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);

        return checkdnsrr($domain);
    }
}
