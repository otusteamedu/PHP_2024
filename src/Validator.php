<?php

declare(strict_types=1);

namespace App;

class Validator
{
    public function sequenceParentheses(string $sequence): bool
    {
        $stack = [];
        for ($i = 0; $i < strlen($sequence); $i++) {
            $bracket = $sequence[$i];

            if ($bracket === '(') {
                array_push($stack, $bracket);
            } elseif ($bracket === ')') {
                if (empty($stack)) {
                    return false;
                }

                array_pop($stack);
            }
        }

        return empty($stack);
    }
}
