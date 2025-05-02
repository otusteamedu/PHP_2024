<?php

declare(strict_types=1);

namespace App\Service;

class EmailVerifier
{
    /**
     * Verify a list of email addresses
     *
     * @param array<string> $emails List of email addresses to verify
     * @return array<string, bool> Results with email as key and verification result as value
     */
    public function verifyEmails(array $emails): array
    {
        $results = [];

        foreach ($emails as $email) {
            $results[$email] = $this->isValidEmail($email);
        }

        return $results;
    }

    /**
     * Check if an email is valid using regex and DNS MX records
     *
     * @param string $email Email to verify
     * @return bool True if email is valid
     */
    public function isValidEmail(string $email): bool
    {
        // Step 1: Basic format validation with regex
        if (!$this->validateEmailFormat($email)) {
            return false;
        }

        // Step 2: Check DNS MX records
        return $this->validateMxRecords($email);
    }

    /**
     * Validate email format using regex
     *
     * @param string $email Email to validate
     * @return bool True if format is valid
     */
    private function validateEmailFormat(string $email): bool
    {
        // RFC 5322 compliant email regex
        $regex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

        return preg_match($regex, $email) === 1;
    }

    /**
     * Validate MX records for the email domain
     *
     * @param string $email Email to validate
     * @return bool True if MX records exist
     */
    private function validateMxRecords(string $email): bool
    {
        // Extract the domain
        $domain = substr(strrchr($email, "@"), 1);

        // Check if MX records exist
        return checkdnsrr($domain, "MX");
    }
}