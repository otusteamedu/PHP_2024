<?php

namespace Evgenyart\EmailValidator;

class Validator
{
    public static function validate($email)
    {
        if (self::validateRegex($email)) {
            return self::validateDns($email);
        } else {
            return false;
        }
    }

    private static function validateRegex($email)
    {
        $result = preg_match('/[A-Za-zа-яА-Я0-9._-]+@[A-Za-zа-яА-Я0-9._-]+\.[A-Za-zа-яА-ЯёЁ]{2,}/u', $email);
        return $result;
    }

    private static function validateDns($email)
    {
        $result = false;
        $parts = explode("@", $email);
        if (isset($parts[1])) {
            if (preg_match('/[а-я]/iu', $parts[1])) {
                $parts[1] = idn_to_ascii($parts[1]);
            }

            $result = checkdnsrr($parts[1]);
        }
        return $result;
    }
}
