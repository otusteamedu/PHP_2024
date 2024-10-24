<?php

declare(strict_types=1);

namespace Evgenyart\Hw19;

use Exception;

class SolutionFractionToRecurringDecimal
{
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($denominator == 0) {
            throw new Exception('Деление на ноль');
        }

        if ($numerator == 0) {
            return '0';
        }

        $result = ((($numerator > 0 && $denominator > 0) || ($numerator < 0 && $denominator < 0)) ? "" : "-");

        $numerator = abs($numerator);
        $denominator = abs($denominator);
        $result .= intdiv($numerator, $denominator);

        $moduloResult = $numerator % $denominator;

        if ($moduloResult == 0) {
            return $result;
        }

        $result .= '.';

        $hashMap = [];

        while ($moduloResult) {
            if (array_key_exists($moduloResult, $hashMap)) {
                $result = substr($result, 0, $hashMap[$moduloResult]) . "(" . substr($result, $hashMap[$moduloResult]) . ")";
                break;
            }

            $hashMap[$moduloResult] = strlen($result);  #позиция, куда потом вставлять скобку

            $moduloResult = $moduloResult * 10;
            $result .= intdiv($moduloResult, $denominator);

            $moduloResult = $moduloResult % $denominator;
        }
        return $result;
    }
}
