<?php

namespace App\Service;

class Validator
{
    public static function validateString(string $string)
    {
        if (empty(trim($string))) {
            return 'String cannot be empty or only whitespace';
        }

        $balance = 0;
        for ($i = 0, $len = strlen($string); $i < $len; $i++) {
            if ($string[$i] === '(') {
                $balance++;
            } elseif ($string[$i] === ')') {
                $balance--;
                if ($balance < 0) {
                    return 'Unbalanced parentheses: closing bracket without opening at position ' . $i;
                }
            }
        }

        if ($balance !== 0) {
            return 'Unbalanced parentheses: more opening than closing brackets';
        }

        return true;
    }
}