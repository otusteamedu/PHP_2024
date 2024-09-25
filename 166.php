<?php

class Solution
{
    /**
     * Complexity: O(n)
     */
    function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($denominator == 0) return "0";

        $negative = ($numerator < 0 && $denominator > 0) || ($numerator > 0 && $denominator < 0) ? "-" : "";

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $integerPart = floor($numerator / $denominator);
        $remainder = $numerator % $denominator;

        if ($remainder == 0) return $negative . $integerPart;

        // Initialize decimal part
        $decimal = ".";
        $seenRemainders = [];

        while ($remainder != 0) {
            if (isset($seenRemainders[$remainder])) {
                $index = $seenRemainders[$remainder];

                $decimal = substr($decimal, 0, $index) . "(" . substr($decimal, $index) . ")";

                break;
            }

            $seenRemainders[$remainder] = strlen($decimal);

            $remainder *= 10;
            $decimal .= floor($remainder / $denominator);

            $remainder %= $denominator;
        }

        return $negative . $integerPart . $decimal;
    }
}
