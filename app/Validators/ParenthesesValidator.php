<?php

declare(strict_types=1);

namespace App\Validators;

class ParenthesesValidator
{
    public function validate(string $parentheses): bool
    {
        $openParenthesesCount = 0;
        $length = strlen($parentheses);

        for ($i = 0; $i < $length; $i++) {
            if ($parentheses[$i] === '(') {
                $openParenthesesCount++;
            } else if ($parentheses[$i] === ')') {
                if ($openParenthesesCount === 0) {
                    return false;
                }

                $openParenthesesCount--;
            }
        }

        return $openParenthesesCount === 0;
    }
}
