<?php

declare(strict_types=1);

namespace VictoriaBabikova\FractionToDecimal;

class Solution
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal(int $numerator, int $denominator): string
    {
        $array = array();
        $modulo = $numerator % $denominator;
        $counter = 1;
        while($modulo != 0) {
            if ($array[$modulo-1] != 0) break;
            $array[$modulo-1] = $counter;
            $modulo *= 10;
            $number  = (number_format($modulo/$denominator,100));
            $number = rtrim($number, '0');
            $explode = explode('.', $number);
            $period .= abs((int)$explode[0]);
            $modulo %= $denominator;
            $counter++;
        }
        if ($modulo != 0) {
            $number  = ($numerator/$denominator);
            if (str_contains((string)$number, '-')) {
                $number  = (number_format($modulo/$denominator,100));
                $number = rtrim($number, '0');
                $part = explode('.', $number);
            } else {
                $part = explode('.', (string)$number);
            }
            return $part[0] .'.'. substr($period, 0, $array[$modulo-1]-1) . '(' . substr($period, $array[$modulo-1]-1) .')';
        } else {
            $number = $numerator/$denominator;
            if (str_contains((string)$number, '-')) {
                $number  = (number_format($numerator/$denominator,100));
                $number = rtrim($number, '.0');
                $number = preg_replace('/,/', '', $number);
                return ($number);
            } else {
                return (string)($number);
            }
        }
    }
}
