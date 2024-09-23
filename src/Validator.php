<?php

declare(strict_types=1);

namespace App;

class Validator
{
    public function isEmails(array $emailAddresses): bool
    {
        foreach ($emailAddresses as $emailAddress) {
            if (!$this->isEmail($emailAddress)) {
                return false;
            }

            return true;
        }
    }

    protected function hasRecord(string $emailAddress): bool
    {
        if (strpos($emailAddress, '@') === false) {
            return false;
        }

        [, $domain] = explode('@', $emailAddress);

        if (!$domain || !checkdnsrr($domain, 'MX')) {
            return false;
        }

        return true;
    }

    protected function isEmail(string $emailAddress): bool
    {
        $isEmail = (bool)preg_match('/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/', $emailAddress);

        if (!$isEmail) {
            return false;
        }

        return $this->hasRecord($emailAddress);
    }
}
