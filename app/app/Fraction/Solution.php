<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Fraction;

final class Solution
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public function fractionToDecimal($numerator, $denominator)
    {
        if ($numerator === 0) {
            return "0";
        }
        $res = (string)((int) (abs($numerator / $denominator)));
        if ($numerator < 0 xor $denominator < 0) {
            $res = "-$res";
        }
        $remainder = $numerator % $denominator;

        if ($remainder === 0) {
            return $res;
        }

        $res .= '.';
        $remMap = [];

        while ($remainder !== 0) {
            if (isset($remMap[$remainder])) {
                $index = $remMap[$remainder];
                $first = substr($res, 0, $index);
                $last = substr($res, $index);
                return "$first($last)";
            }
            $remMap[$remainder] = strlen($res);
            $remainder *= 10;
            $int = abs((int) ($remainder / $denominator));
            $remainder = $remainder % $denominator;
            $res .= $int;
        }

        return $res;
    }
}
