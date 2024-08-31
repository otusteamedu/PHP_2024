<?php

namespace HW4;

class Checker
{
    public function isEmpty(string $string): bool
    {
        return empty(trim($string));
    }

    public function isCorrect(string $string): bool
    {
        $counter = 0;
        foreach (str_split($string) as $letter) {
            if ($letter == '(') ++$counter;
            if ($letter == ')') --$counter;
            if ($counter < 0) {
                return false;
            }
        }

        if ($counter !== 0) {
            return false;
        }

        return true;
    }
}
