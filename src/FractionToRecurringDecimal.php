<?php

declare(strict_types=1);

namespace App;

class FractionToRecurringDecimal
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public function fractionToDecimal($numerator, $denominator)
    {
        if ($numerator == 0) {
            return "0";
        }

        $result = [];

        // Определяем знак
        if (($numerator < 0) ^ ($denominator < 0)) {
            $result[] = "-";
        }

        // Приводим к положительным значениям
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        // Целая часть
        $result[] = strval(intval($numerator / $denominator));
        $remainder = $numerator % $denominator;

        if ($remainder == 0) {
            return implode('', $result);
        }

        $result[] = ".";

        // Дробная часть
        $map = [];
        while ($remainder != 0) {
            if (isset($map[$remainder])) {
                $result[] = ")";
                array_splice($result, $map[$remainder], 0, "(");
                break;
            }

            $map[$remainder] = count($result);

            $remainder *= 10;
            $result[] = strval(intval($remainder / $denominator));
            $remainder %= $denominator;
        }

        return implode('', $result);
    }
}
