<?php

declare(strict_types=1);

// https://leetcode.com/problems/fraction-to-recurring-decimal/
final class Solution
{
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($numerator == 0) {
            return "0";
        }

        $result = [];

        if (($numerator < 0) ^ ($denominator < 0)) {
            $result[] = "-";
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $result[] = strval(intval($numerator / $denominator));
        $remainder = $numerator % $denominator;

        if ($remainder == 0) {
            return implode('', $result);
        }

        $result[] = ".";

        $map = [];

        while ($remainder != 0) {
            if (isset($map[$remainder])) {
                $result[] = ")";

                array_splice($result, $map[$remainder], 0, "(");

                break;
            }

            $map[$remainder] = count($result);

            $remainder *= 10;
            $result[] = strval(intval($remainder / $denominator));
            $remainder %= $denominator;
        }

        return implode('', $result);
    }
}
