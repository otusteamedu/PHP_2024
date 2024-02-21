<?php

namespace Akornienko\App\hw4;

class BracketsValidator
{
    public function validate(string $brackets): bool {
        if (!strlen($brackets)) {
            return false;
        }

        $bracketsArr = str_split($brackets);
        $stack = [];

        foreach ($bracketsArr as $bracket) {
            if ($bracket === '(') {
                $stack[] = $bracket;
            } elseif ($bracket === ')' && count($stack) > 0) {
                array_pop($stack);
            } else {
                return false;
            }
        }
        return count($stack) === 0;
    }
}