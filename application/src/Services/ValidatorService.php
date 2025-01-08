<?php

namespace Den\Hw5\Services;

class ValidatorService
{
    public function validate(string $str): bool
    {
        $stack = [];
        foreach (mb_str_split($str) as $symbol) {
            if ($symbol === '(') {
                $stack[] = $symbol;
            } elseif ($symbol === ')') {
                if (empty($stack)) {
                    return false;
                }

                array_pop($stack);
            }
        }

        return empty($stack);
    }
}
