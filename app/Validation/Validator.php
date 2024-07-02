<?php

declare(strict_types=1);

namespace App\Validation;

final class Validator
{
    public function isValid(string $value): bool
    {
        $stack = [];
        $open = ['('];
        $pairs = ['()'];
        $length = strlen($value);

        for ($i = 0; $i < $length; $i++) {
            $current = $value[$i];
            if (in_array($current, $open)) {
                $stack[] = $current;
            } else {
                $previous = array_pop($stack);
                $pair = "{$previous}{$current}";
                if (!in_array($pair, $pairs)) {
                    return false;
                }
            }
        }

        return count($stack) === 0;
    }
}
