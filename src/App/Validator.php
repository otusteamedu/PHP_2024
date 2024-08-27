<?php

declare(strict_types=1);

namespace VSukhov\Validator\App;

class Validator
{
    public static function validate(array $emails): bool
    {
        $result = true;
        foreach ($emails as $email) {
            if (!is_string($email)) {
                $result = false;
            }
            if (!self::isEmail($email)) {
                $result = false;
            }
            if (!self::hasRecord($email)) {
                $result = false;
            }
        }

        return $result;
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
