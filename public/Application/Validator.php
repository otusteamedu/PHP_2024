<?php

declare(strict_types=1);

namespace FTursunboy\PhpWebservers;

use InvalidArgumentException;

class Validator
{
    public function checkData(string $data): bool
    {
        if (trim($data) === '') {
            throw new InvalidArgumentException('Input cannot be empty');
        }

        $chars = str_split($data);
        $braceTracker = [];

        foreach ($chars as $char) {
            if ($char === '(') {
                $braceTracker[] = '(';
            } elseif ($char === ')') {
                if (empty($braceTracker) || array_pop($braceTracker) !== '(') {
                    throw new InvalidArgumentException('Mismatched closing parenthesis');
                }
            }
        }

        if (!empty($braceTracker)) {
            throw new InvalidArgumentException('Unmatched opening parenthesis');
        }

        return true;
    }
}
