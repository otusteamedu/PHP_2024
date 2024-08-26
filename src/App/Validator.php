<?php

namespace Komarov\Hw5\App;

class Validator
{
    public static function validateEmails(array $emails): bool
    {
        foreach ($emails as $email) {
            if (!(self::isEmail($email) && self::hasRecord($email))) {
                return false;
            }
        }

        return true;
    }

    private static function isEmail(string $email): bool
    {
        return preg_match('/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/', $email);
    }

    private static function hasRecord(string $email): bool
    {
        return checkdnsrr(explode('@', $email)[1]);
    }
}
