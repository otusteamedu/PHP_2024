<?php

declare(strict_types=1);

namespace Kagirova\Hw6;

class EmailValidator
{
    public function validate(string $email): bool
    {
        if ($this->validateEmailByRegex($email)) {
            $domain = substr(strchr($email, "@"), 1);
            if ($this->validateDNS($domain)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function validateEmailByRegex($email): bool
    {
        return preg_match('/^\\S+@\\S+\\.\\S+$/', $email) == 1;
    }

    private function validateDNS($domain): bool
    {
        return checkdnsrr($domain);
    }
}
