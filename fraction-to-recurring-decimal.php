<?php

/**
 * Сложность O(n)
 * где n - $denominator
 * @param $numerator
 * @param $denominator
 * @return string
 */
function fractionToDecimal($numerator, $denominator): string
{
    if ($numerator === 0) {
        return "0";
    }

    if (($numerator < 0) ^ ($denominator < 0)) {
        $result = "-";
    }
    $quotient = intval($numerator / $denominator);
    $result .= abs($quotient) . "";
    $reminder = $numerator - ($quotient * $denominator);
    if ($reminder === 0) {
        return $result;
    } else {
        $result .= '.';
    }
    $afterComma = [];
    $reminders = [];

    while ($reminder !== 0) {
        $numerator = $quotient === 0 ? intval($numerator . 0) : intval($reminder . 0);
        $quotient = intval($numerator / $denominator);
        if ($reminders[$reminder]) {
            array_splice($afterComma, $reminders[$reminder], 0, '(');
            $afterComma[] = ')';
            break;
        }
        $afterComma[] = abs($quotient);
        $reminders[$reminder] = count($afterComma) - 1;
        $reminder = $numerator - ($quotient * $denominator);
    }
    return $result . implode('', $afterComma);
}
