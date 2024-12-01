<?php

declare(strict_types=1);

namespace FractionDecimal;

class Solution
{
    public function fractionToDecimal(int $numerator, int $denominator): string
    {

        if ($numerator % $denominator == 0) {
            return (string)($numerator / $denominator);
        }

        $result = '';
        if (($numerator < 0) ^ ($denominator < 0)) {
            $result = '-';
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $result .= (int)($numerator / $denominator);
        $remainder = $numerator % $denominator;

        if ($remainder == 0) {
            return $result;
        }

        $result .= '.';
        $map = [];
        while ($remainder != 0) {
            if (isset($map[$remainder])) {
                $index = $map[$remainder];
                return substr($result, 0, $index) . '(' . substr($result, $index) . ')';
            }

            $map[$remainder] = strlen($result);
            $remainder *= 10;
            $result .= (int)($remainder / $denominator);
            $remainder = $remainder % $denominator;
        }

        return $result;
    }
}

// Сложность O(n)
