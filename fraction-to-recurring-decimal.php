<?php

declare(strict_types=1);

class Solution
{

    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($numerator === 0) {
            return '0';
        }
        $res = '';
        if ($numerator * $denominator < 0) $res .= '-';

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $res.= floor($numerator / $denominator);
        $rest = $numerator % $denominator;

        if ($rest === 0) return $res;

        $res .= '.';
        $hash = [];

        while ($rest) {
            if (isset($hash[$rest])) {
                $res = substr($res, 0, $hash[$rest]) . '(' . substr($res, $hash[$rest]) . ')';
                break;
            }
            $hash[$rest] = strlen($res);
            $rest *= 10;
            $res.= floor($rest / $denominator);
            $rest %= $denominator;
        }
        return $res;
    }
}

$solution = new Solution();
//echo $solution->fractionToDecimal(1, 2) . PHP_EOL;
echo $solution->fractionToDecimal(4, 333) . PHP_EOL;
