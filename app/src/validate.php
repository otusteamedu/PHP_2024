<?php

declare(strict_types=1);

namespace App\Validate;

function isValidString(string $string): bool
{
    $stack = [];

    $opened = '(';
    $closed = ')';

    foreach (str_split($string) as $char) {
        if ($char === $opened) {
            $stack[] = $char;
        } else if ($char === $closed && end($stack) === $opened) {
            array_pop($stack);
        } else {
            return false;
        }
    }

    return count($stack) === 0;
}
