<?php

namespace App;

class EmailValidator
{
    public function validateEmail(string $email): bool
    {
        $result = true;

        // Validate email with regex
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        }

        // Extract domain and check DNS MX records
        $domain = substr(strrchr($email, '@'), 1);
        if (!$domain || !checkdnsrr($domain, 'MX')) {
            $result = false;
        }

        return $result;
    }
}