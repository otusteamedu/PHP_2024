<?php

class Solution {

    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal($numerator, $denominator) {
        if ($numerator == 0) {
            return "0";
        }

        // Определяем знак результата
        $result = "";
        if (($numerator < 0) ^ ($denominator < 0)) {
            $result .= "-";
        }

        // Работаем с абсолютными значениями
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        // Целая часть
        $result .= intdiv($numerator, $denominator);

        // Если нет остатка, возвращаем результат
        $remainder = $numerator % $denominator;
        if ($remainder == 0) {
            return $result;
        }

        // Дробная часть
        $result .= ".";

        // Словарь для отслеживания остатков и их позиций
        $map = [];
        while ($remainder != 0) {
            // Если остаток уже встречался, значит нашли повторяющуюся часть
            if (isset($map[$remainder])) {
                $result = substr($result, 0, $map[$remainder]) . "(" .
                    substr($result, $map[$remainder]) . ")";
                break;
            }

            // Запоминаем позицию остатка
            $map[$remainder] = strlen($result);

            $remainder *= 10;
            $result .= intdiv($remainder, $denominator);
            $remainder %= $denominator;
        }

        return $result;
    }
}

/**
 * Временная сложность: O(n)
 * Пространственная сложность: O(n)
 */
