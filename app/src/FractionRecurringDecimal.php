<?php

declare(strict_types=1);

namespace Lrazumov\Hw29;

class FractionRecurringDecimal
{
    /**
     * @param int $numerator
     * @param int $denominator
     * @return string
     */
    public function solution(
      int $numerator,
      int $denominator
    ): string
    {
        if (!$numerator) {
            return 0;
        }
        $sign = '';
        if ($numerator < 0 || $denominator < 0) {
            $sign = '-';
        }
        if ($numerator < 0 && $denominator < 0) {
            $sign = '';
        }
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $left_part = intdiv($numerator, $denominator);

        $numerator = $numerator % $denominator;
        if (!$numerator) {
            return $sign . $left_part;
        }

        $numerators = [];
        $right_part = '';
        $index = 0;
        while($numerator) {
            $position = $numerators[$numerator] ?? FALSE;
            $numerators[$numerator] = $index++;
            $numerator *= 10;
            if ($numerator < $denominator) {
                $right_part .= '0';
                continue;
            }
            $int_div = intdiv($numerator, $denominator);

            if ($position === 0) {
                return $sign . $left_part . '.(' . $right_part . ')';
            }
            elseif ($position) {
                return $sign . $left_part . '.' . substr($right_part, 0, $position) . '(' . substr($right_part, $position) . ')';
            }
            $numerator = $numerator % $denominator;
            $right_part .= $int_div;
            if ($numerator === 0) {
                break;
            }
        }
        return $sign . $left_part . '.' . $right_part;
    }
}
