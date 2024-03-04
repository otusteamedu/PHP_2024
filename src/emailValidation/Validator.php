<?php

namespace AKornienko\Php2024\EmailValidation;

class Validator
{
    public static function validate(string $email): bool
    {
        if (!self::validateEmail($email)) {
            return false;
        }

        $emailDomain = explode('@', $email)[1];
        return self::checkDnsMx($emailDomain);
    }

    private static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private static function checkDnsMx(string $emailDomain): bool
    {
        return checkdnsrr($emailDomain);
    }
}
