<?php


class Solution
{
    function fractionToDecimal($numerator, $denominator)
    {
        if ($numerator === 0) {
            return "0";
        }

        $result = "";

        if (($numerator < 0 && $denominator > 0) || ($numerator > 0 && $denominator < 0)) {
            $result .= "-";
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $result .= intdiv($numerator, $denominator);
        $remainder = $numerator % $denominator;

        if ($remainder === 0) {
            return $result;
        }

        $result .= ".";

        $map = [];

        while ($remainder !== 0) {
            if (isset($map[$remainder])) {
                $start = $map[$remainder];
                return substr($result, 0, $start) . "(" . substr($result, $start) . ")";
            }

            $map[$remainder] = strlen($result);
            $remainder *= 10;
            $result .= intdiv($remainder, $denominator);
            $remainder %= $denominator;
        }

        return $result;
    }
}
