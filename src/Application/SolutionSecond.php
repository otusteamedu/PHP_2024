<?php

namespace EkaterinaKonyaeva\OtusComposerApp\Application;

class SolutionSecond
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal($numerator, $denominator): string
    {
        if ($numerator == 0) {
            return "0";
        }

        $result = "";
        $sign = ($numerator * $denominator) < 0 ? "-" : "";
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $intPart = intdiv($numerator, $denominator);
        $remainder = $numerator % $denominator;

        $result .= $sign . strval($intPart);
        if ($remainder == 0) {
            return $result;
        }

        $result .= ".";
        $positions = [];
        $decimal = "";
        while ($remainder != 0 && !isset($positions[$remainder])) {
            $positions[$remainder] = strlen($decimal);
            $remainder *= 10;
            $decimal .= strval(intdiv($remainder, $denominator));
            $remainder %= $denominator;
        }

        if ($remainder == 0) {
            return $result . $decimal;
        } else {
            $repeatedStart = $positions[$remainder];
            return $result . substr($decimal, 0, $repeatedStart) . "(" . substr($decimal, $repeatedStart) . ")";
        }

    }
}