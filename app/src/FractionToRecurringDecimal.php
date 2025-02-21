<?php

namespace Anatolyshilyaev\App;

//Сложность O(n)
class Solution
{
    /**
     * @param int $numerator
     * @param int $denominator
     * @return String
     */
    function fractionToDecimal($numerator, $denominator)
    {
        if ($numerator == 0) return "0";

        $result = "";

        // Определяем знак результата
        if (($numerator < 0) ^ ($denominator < 0)) {
            $result .= "-";
        }

        // Берем абсолютные значения
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        // Добавляем целую часть
        $integerPart = intdiv($numerator, $denominator);
        $result .= strval($integerPart);

        // Вычисляем остаток
        $remainder = $numerator % $denominator;
        if ($remainder == 0) {
            return $result; // Если нет дробной части, возвращаем число
        }

        // Добавляем десятичную точку
        $result .= ".";

        // Запоминаем позицию остатков, чтобы отслеживать повторения
        $map = [];

        while ($remainder != 0) {
            // Если остаток уже был, значит дробная часть повторяется
            if (isset($map[$remainder])) {
                $startPos = $map[$remainder]; // Где начался повтор
                $result = substr($result, 0, $startPos) . "(" . substr($result, $startPos) . ")";
                return $result;
            }

            // Запоминаем, где этот остаток появился
            $map[$remainder] = strlen($result);

            // Умножаем остаток на 10, делим снова
            $remainder *= 10;
            $result .= strval(intdiv($remainder, $denominator));
            $remainder %= $denominator;
        }

        return $result;
    }
}
