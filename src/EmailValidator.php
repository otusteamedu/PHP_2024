<?php

declare(strict_types=1);

namespace Afilipov\Hw6;

class EmailValidator
{
    public function validate(string $email): bool
    {
        if (!$this->isEmailValidFormat($email)) {
            return false;
        }

        $domain = explode('@', $email)[1] ?? null;
        if ($domain === null) {
            return false;
        }

        return $this->isDNSValid($domain);
    }

    private function isEmailValidFormat(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function isDNSValid(string $domain): bool
    {
        $normalizedDomain = $domain . '.';

        return checkdnsrr($normalizedDomain);
    }
}
