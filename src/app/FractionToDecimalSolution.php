<?php

declare(strict_types=1);

namespace App;

class FractionToDecimalSolution
{
    public static function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($numerator == 0) {
            return '0';
        }

        $res = [];

        if (($numerator < 0) ^ ($denominator < 0)) {
            $res[] = '-';
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $res[] = strval(intval($numerator / $denominator));
        $remain = $numerator % $denominator;

        if ($remain === 0) {
            return implode('', $res);
        }

        $res[] = '.';

        $map = [];
        while ($remain != 0) {
            if (isset($map[$remain])) {
                $res[] = ")";
                array_splice($res, $map[$remain], 0, "(");
                break;
            }

            $map[$remain] = count($res);

            $remain *= 10;
            $res[] = strval(intval($remain / $denominator));
            $remain %= $denominator;
        }

        return implode('', $res);
    }
}
