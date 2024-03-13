<?php

namespace Ahar\Hw6;

class EmailValidator
{
    public function validate(string $email): bool
    {
        if (empty($email)) {
            return false;
        }

        if (!$this->isValidateEmail($email)) {
            return false;
        }


        return $this->isDsnValidate($email);
    }

    private function isValidateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function isDsnValidate(string $email): bool
    {
        $domain = explode('@', $email)[1] ?? null;
        if ($domain === null) {
            return false;
        }

        $formatDomain = $domain . '.';

        return checkdnsrr($formatDomain);
    }
}
