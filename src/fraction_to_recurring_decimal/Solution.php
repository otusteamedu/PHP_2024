<?php

declare(strict_types=1);

namespace Afilipov\Hw18\fraction_to_recurring_decimal;

use InvalidArgumentException;

class Solution
{
    /**
     * Алгоритмическая сложность - O(n)
     * @param int $numerator
     * @param int $denominator
     * @return string
     */
    public function fractionToDecimal(int $numerator, int $denominator): string {
        if ($denominator === 0) {
            throw new InvalidArgumentException("Denominator cannot be zero.");
        }

        if ($numerator === 0) {
            return "0";
        }

        $result = "";

        if (($numerator < 0) != ($denominator < 0)) {
            $result .= "-";
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $integerPart = intdiv($numerator, $denominator);
        $result .= $integerPart;

        $remainder = $numerator % $denominator;

        if ($remainder == 0) {
            return $result;
        }

        $result .= ".";
        $remainderPositions = [];

        while ($remainder != 0) {
            if (isset($remainderPositions[$remainder])) {
                $start = $remainderPositions[$remainder];
                $nonRepeatingPart = substr($result, 0, $start);
                $repeatingPart = substr($result, $start);
                return $nonRepeatingPart . "(" . $repeatingPart . ")";
            }

            $remainderPositions[$remainder] = strlen($result);

            $remainder *= 10;
            $nextDigit = intdiv($remainder, $denominator);
            $result .= $nextDigit;
            
            $remainder %= $denominator;
        }

        return $result;
    }
}
