<?php

declare(strict_types=1);

namespace AlexanderGladkov\FractionToRecurringDecimal;

class Solution
{
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($numerator === 0) {
            return '0';
        }

        if ($numerator * $denominator < 0) {
            $sign = '-';
        } else {
            $sign = '';
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);
        $integerPart = intdiv($numerator, $denominator);
        $remainder = $numerator % $denominator;
        if ($remainder === 0) {
            return $sign . $integerPart;
        }

        $positions = [];
        $result = $sign . $integerPart . '.';
        while ($remainder !== 0) {
            if (isset($positions[$remainder])) {
                $position = $positions[$remainder];
                $result = substr($result, 0, $position) . '(' . substr($result, $position) . ')';
                break;
            }

            $positions[$remainder] = strlen($result);
            $remainder = $remainder * 10;
            $result .= intdiv($remainder, $denominator);
            $remainder = $remainder % $denominator;
        }

        return $result;
    }
}
