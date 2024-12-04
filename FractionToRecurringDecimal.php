<?php

namespace EShulman\hw19;

class Solution
{
    /**
    * @param Integer $numerator
    * @param Integer $denominator
    * @return String
    */
    public function fractionToDecimal($numerator, $denominator)
    {
        if ($numerator === 0) {
            return '0';
        }

        $result = '';

        if ($numerator < 0 xor $denominator < 0) {
            $result .= '-';
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $result .= intval($numerator / $denominator);
        $remainder = $numerator % $denominator;

        if ($remainder === 0) {
            return $result;
        }

        $result .= '.';
        $map = [];

        while ($remainder !== 0) {
            $map[$remainder] = strlen($result);
            $remainder *= 10;
            $result .= intval($remainder / $denominator);
            $remainder %= $denominator;

            if (isset($map[$remainder])) {
                $index = $map[$remainder];
                $result = substr($result, 0, $index)
                        . '(' . substr($result, $index) . ')';
                break;
            }
        }

        return $result;
    }
}
