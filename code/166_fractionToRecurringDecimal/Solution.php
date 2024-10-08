<?php

declare(strict_types=1);

namespace Otus\FractionToDecimal;

// Вычислительная сложность O(n) т.к. алгоритм в цикле перебирает цифры делителя.
// Пространственная сложность O(n) т.к. на каждой итерации цикла может быть сохранено не более n символов делителя.
class Solution {

    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($numerator == 0) {
            return "0";
        }

        $result = '';

        $isNegative = ($numerator > 0) ^ ($denominator > 0);
        $result .= $isNegative ? "-" : "";

        $numerator_abs = abs($numerator);
        $denominator_abs = abs($denominator);

        $result .= floor($numerator_abs / $denominator_abs);

        $remainder = $numerator_abs % $denominator_abs;

        if ($remainder === 0) {
            return $result;
        }

        $result .= '.';

        $seen_remainders = [];

        while ($remainder !== 0) {
            if (in_array($remainder, $seen_remainders, true)) {
                $idx = $seen_remainders[$remainder];
                $result = substr_replace($result, '(', $idx, 0);
                $result .= ')';
                break;
            }

            $seen_remainders[$remainder] = strlen($result);
            $remainder *= 10;
            $result .= floor($remainder / $denominator_abs);
            $remainder %= $denominator_abs;
        }

        return $result;
    }
}
