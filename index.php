<?php

$emails = [
    'test@example.com',
    'invalid-email',
    'another.test@domain.com',
    'no.mx.record@nonexistentdomain.xyz'
];

$results = verifyEmailList($emails);

foreach ($results as $email => $isValid) {
    echo $email . ' - ' . ($isValid ? 'Valid' : 'Invalid') . PHP_EOL;
}

function verifyEmailList(array $emails): array
{
    $results = [];

    foreach ($emails as $email) {
        $results[$email] = verifyEmail($email);
    }

    return $results;
}

function verifyEmail(string $email): bool
{
    if (!isValidEmailFormat($email)) {
        return false;
    }

    if (!hasMxRecord($email)) {
        return false;
    }

    return true;
}

function isValidEmailFormat(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function hasMxRecord(string $email): bool
{
    $domain = substr(strrchr($email, "@"), 1);
    return checkdnsrr($domain, "MX");
}
