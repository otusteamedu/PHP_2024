<?php

namespace sd;

class Solution
{

    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public function fractionToDecimal($numerator, $denominator)
    {
        if (empty($numerator)) {
            return '0';
        }

        $isNegative = ($numerator * $denominator) < 0;
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $firstPart = (int)($numerator / $denominator);
        $result = ($isNegative ? '-' : '') . $firstPart;
        $modulo = $numerator % $denominator;
        if ($modulo == 0) {
            return $result;
        }

        $result .= '.';
        $positions = [];
        $decimal = '';

        while ($modulo != 0 && !isset($positions[$modulo])) {
            $positions[$modulo] = strlen($decimal);
            $modulo *= 10;
            $decimal .= intdiv($modulo, $denominator);
            $modulo %= $denominator;
        }

        if ($modulo == 0) {
            return $result . $decimal;
        } else {
            $repeatedStart = $positions[$modulo];
            return $result . substr($decimal, 0, $repeatedStart) . "(" . substr($decimal, $repeatedStart) . ")";
        }
    }
}
