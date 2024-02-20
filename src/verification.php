<?php

declare(strict_types=1);

namespace Verification;

function verifyBrackets(string $brackets): bool
{
    $left = '(';
    $right = ')';
    $stack = [];

    foreach (str_split($brackets) as $bracket) {
        if ($bracket === $left) {
            array_push($stack, $bracket);
        } elseif ($bracket === $right) {
            $char = array_pop($stack);

            if ($char === null || "{$char}{$bracket}" !== "{$left}{$right}") {
                return false;
            }
        } else {
            return false;
        }
    }

    return count($stack) === 0;
}
