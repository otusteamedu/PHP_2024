<?php

function getIntersectionNode($headA, $headB)
{
    $a = $headA;
    $b = $headB;

    while ($a !== $b) {
        $a = $a === null ? $headB : $a->next;
        $b = $b === null ? $headA : $b->next;
    }

    return $a;
}

function fractionToDecimal($numerator, $denominator)
{
    if ($numerator === 0) {
        return '0';
    }

    $result = '';

    if (($numerator < 0) ^ ($denominator < 0)) {
        $result .= '-';
    }

    $numerator = abs($numerator);
    $denominator = abs($denominator);
    $result .= intdiv($numerator, $denominator);
    $remainder = $numerator % $denominator;

    if ($remainder === 0) {
        return $result;
    }

    $result .= '.';
    $remainderMap = [];

    while ($remainder !== 0) {
        if (isset($remainderMap[$remainder])) {
            $index = $remainderMap[$remainder];
            return substr($result, 0, $index) . "(" . substr($result, $index) . ")";
        }

        $remainderMap[$remainder] = strlen($result);
        $remainder *= 10;
        $result .= intdiv($remainder, $denominator);
        $remainder %= $denominator;
    }

    return $result;
}
