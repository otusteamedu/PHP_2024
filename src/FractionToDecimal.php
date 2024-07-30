<?php

declare(strict_types=1);

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */
class FractionToDecimal
{
    //Time complexity = O(N)
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public function fractionToDecimal($numerator, $denominator)
    {
        $period = "";
        $answer = "";

        if ($numerator == 0) {
            return "0";
        }
        if (($numerator < 0 xor $denominator < 0)) {
            $answer .= "-";
            $numerator = abs($numerator);
            $denominator = abs($denominator);
        }
        $answer .= (int)($numerator / $denominator);
        $numerator = $numerator % $denominator * 10;
        if ($numerator == 0) {
            return $answer;
        }
        $answer .= '.';
        $haspMap = [];
        while ($numerator != 0) {
            if (isset($haspMap[$numerator])) {
                if ($haspMap[$numerator] == 1) {
                    break;
                }
                $period .= (int)($numerator / $denominator);
                $haspMap[$numerator] = 1;
            } else {
                $answer .= (int)($numerator / $denominator);
                $haspMap[$numerator] = 0;
            }
            $numerator = $numerator % $denominator * 10;
        }
        if (!empty($period)) {
            $answer = str_replace($period, '', $answer);
            return $answer . '(' . $period . ')';
        }
        return $answer;
    }
}

