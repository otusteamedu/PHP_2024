<?php

namespace Ali;

class ValidateEmail
{
    public function validate(string $email): bool
    {
        return $this->isValidFormat($email) && $this->hasMxRecords($email);
    }

    private function isValidFormat(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function hasMxRecords(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain, 'MX');
    }

}