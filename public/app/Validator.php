<?php

namespace App;

class Validator
{
    public function isValidParentheses(string $input): bool
    {
        $stack = [];
        $length = strlen($input);

        for ($i = 0; $i < $length; $i++) {
            if ($input[$i] === '(') {
                array_push($stack, '(');
            } elseif ($input[$i] === ')') {
                if (empty($stack)) {
                    return false;
                }
                array_pop($stack);
            } else {
                return false;
            }
        }

        return empty($stack);
    }
}
