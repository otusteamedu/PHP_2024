<?php

declare(strict_types=1);

namespace Dsmolyaninov\Hw6;

class EmailVerifier
{
    public function isValidEmailFormat(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function hasValidMXRecords(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain, 'MX');
    }

    public function verifyEmails(array $emails): array
    {
        $results = [];
        foreach ($emails as $email) {
            $isValidFormat = $this->isValidEmailFormat($email);
            $hasMXRecords = $isValidFormat && $this->hasValidMXRecords($email);
            $results[$email] = $isValidFormat && $hasMXRecords;
        }
        return $results;
    }
}
