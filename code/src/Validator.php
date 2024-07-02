<?php

declare(strict_types=1);

namespace TBublikova\Php2024;

class Validator
{
    public function validate(string $input): bool
    {
        if (empty($input)) {
            return false;
        }

        $stack = [];
        foreach (str_split($input) as $char) {
            if ($char === '(') {
                $stack[] = $char;
            } elseif ($char === ')') {
                if ($stack === []) {
                    return false;
                }
                array_pop($stack);
            }
        }

        return $stack === [];
    }
}
