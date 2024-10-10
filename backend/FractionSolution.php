<?php

namespace TBublikova\Solutions;

class FractionSolution
{
    public function fractionToDecimal($numerator, $denominator)
    {
        if ($numerator == 0) {
            return "0";
        }

        $sign = (($numerator < 0) ^ ($denominator < 0)) ? "-" : "";
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $integerPart = floor($numerator / $denominator);
        $remainder = $numerator % $denominator;

        if ($remainder == 0) {
            return $sign . $integerPart;
        }

        $result = $sign . $integerPart . ".";
        $map = [];

        while ($remainder != 0) {
            if (isset($map[$remainder])) {
                $start = $map[$remainder];
                return substr($result, 0, $start) . "(" . substr($result, $start) . ")";
            }

            $map[$remainder] = strlen($result);
            $remainder *= 10;
            $result .= floor($remainder / $denominator);
            $remainder %= $denominator;
        }

        return $result;
    }
}
