<?php

namespace VladimirGrinko\Leetcode;

class Fraction
{
    /*
    Сложность O(n), где n - это делитель
    Цикл ограничен числом возможных остатков при делении, которое не превышает делитель
    */
    public static function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($numerator % $denominator == 0) {
            return (string)($numerator / $denominator);
        }

        $sign = ($numerator < 0) ^ ($denominator < 0) ? "-" : "";

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $leftPart = intdiv($numerator, $denominator);
        $result = $sign . $leftPart . ".";

        $rest = $numerator % $denominator;
        $restArr = [];
        $fractionPart = "";

        while ($rest != 0) {
            if (isset($restArr[$rest])) {
                $startIndex = $restArr[$rest];
                $fractionPart = substr($fractionPart, 0, $startIndex) . "(" . substr($fractionPart, $startIndex) . ")";
                return $result . $fractionPart;
            }

            $restArr[$rest] = strlen($fractionPart);

            $rest *= 10;
            $fractionPart .= intdiv($rest, $denominator);
            $rest %= $denominator;
        }

        return $result . $fractionPart;
    }
}
