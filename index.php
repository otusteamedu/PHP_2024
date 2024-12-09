<?php

/**
 * Validates a list of email addresses using regex and DNS MX record checks.
 *
 * @param array $emails List of email addresses to validate.
 * @return array An associative array with email as key and validation result (true/false) as value.
 */
function validateEmails(array $emails): array
{
    $results = [];
    
    foreach ($emails as $email) {
        // Validate email with regex
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $results[$email] = false;
            continue;
        }

        // Extract domain and check DNS MX records
        $domain = substr(strrchr($email, '@'), 1);
        if (!$domain || !checkdnsrr($domain, 'MX')) {
            $results[$email] = false;
            continue;
        }

        // Email is valid
        $results[$email] = true;
    }

    return $results;
}

// Example usage
$emailsToCheck = [
    "google.com",
    "fake-email",
    "test@test.ru"
];

$validationResults = validateEmails($emailsToCheck);

// Output the results
foreach ($validationResults as $email => $isValid) {
    echo $email . ' is ' . ($isValid ? 'valid' : 'invalid') . PHP_EOL;
}