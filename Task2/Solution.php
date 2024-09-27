<?php

declare(strict_types=1);

namespace Task2;

class Solution
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal($numerator, $denominator)
    {
        if ($numerator === 0) {
            return '0';
        }

        $result = '';

        if (($numerator < 0) xor ($denominator < 0)) {
            $result .='-';
            $numerator = abs($numerator);
            $denominator = abs($denominator);
        }

        $result .= strval((int)($numerator / $denominator));

        $reminder = $numerator % $denominator;
        $mantice = '';
        $hash = [];

        while ($reminder != 0) {
            $hash[$reminder] = strlen($mantice);
            $reminder *= 10;
            $cd = (int)($reminder / $denominator);
            $reminder = $reminder % $denominator;
            if (isset($hash[$reminder])) {
                $mantice = substr($mantice, 0, $hash[$reminder]) . '(' . substr($mantice, $hash[$reminder]) . $cd . ')';
                break;
            } else {
                $mantice .= $cd;
            }
        }

        if (!empty($mantice)) {
            $result .= '.' . $mantice;
        }

        return $result;
    }
}
