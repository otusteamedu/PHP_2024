<?php

namespace Ekonyaeva\Otus;

class EmailValidate
{
    public static function validateArray(array $listOfEmails): array
    {
        return array_map(fn($email) => static::validate($email), $listOfEmails);
    }

    public static function validate(string $email): bool
    {
        return static::regexValidation($email) && static::MXValidation($email);
    }

    protected static function regexValidation(string $email): bool
    {
        return boolval(filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    protected static function MXValidation(string $email): bool
    {
        $domain = explode('@', $email)[1];
        return checkdnsrr($domain, 'MX');
    }

    public static function printValidationResults(array $emails, array $results): void
    {
        foreach ($results as $key => $result) {
            if (!$result) {
                echo $emails[$key] . " - определён как невалидный " . '<br>';
            } else {
                echo $emails[$key] . " - определён как валидный " . '<br>';
            }
        }
    }
}