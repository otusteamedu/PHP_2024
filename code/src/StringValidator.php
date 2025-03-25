<?php

namespace App;

class StringValidator
{
    public static function validateString(string $str): bool
    {
        $balance = 0;

        for ($i = 0, $len = strlen($str); $i < $len; $i++) {
            if ($str[$i] === '(') {
                $balance++;
            } elseif ($str[$i] === ')') {
                $balance--;
            }

            // Если на каком-то этапе баланс < 0, значит, скобки некорректны
            if ($balance < 0) {
                return false;
            }
        }

        // Строка корректна, если баланс в конце = 0
        return $balance === 0;
    }

    public static function isNotEmpty(string $str): bool
    {
        return $str != '';
    }
}