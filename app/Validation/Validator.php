<?php

declare(strict_types=1);

namespace App\Validation;

final class Validator
{
    public function isValid(string $value): bool
    {
        if (empty($value)) {
            return false;
        }

        $cnt = 0;
        $open = '(';
        $close = ')';
        $length = strlen($value);

        for ($i = 0; $i < $length; $i++) {
            if ($value[$i] === $open) {
                $cnt++;
            } elseif ($value[$i] === $close) {
                $cnt--;
            }

            if ($cnt < 0) {
                return false;
            }
        }

        return $cnt === 0;
    }
}
