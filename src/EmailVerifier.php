<?php

declare(strict_types=1);

namespace ABuinovskiy\Hw6;

use const FILTER_VALIDATE_EMAIL;

class EmailVerifier
{
    /**
     * @param string $email
     * @return bool
     */
    public function isValidEmailFormat(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function isValidMXRecord(string $email): bool
    {
        $domain = substr(strstr($email, '@'), 1);
        return checkdnsrr($domain, 'MX');
    }

    /**
     * @param array $emails
     * @return array
     */
    public function validateEmails(array $emails): array
    {
        $verifyEmails = [];
        foreach ($emails as $email) {
            $verifyEmails[$email] = $this->isValidEmailFormat($email) && $this->isValidMXRecord($email);
        }

        return $verifyEmails;
    }
}
