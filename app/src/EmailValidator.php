<?php

declare(strict_types=1);

namespace Kagirova\Hw6;

class EmailValidator
{
    public function validate(string $email): bool
    {
        if (!$this->validateEmailByRegex($email)) {
            return false;
        }
        $domain = substr(strchr($email, "@"), 1);
        return $this->validateDNS($domain);
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
