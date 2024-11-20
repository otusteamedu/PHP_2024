<?php

namespace AlexAgapitov\OtusComposerProject;

class Solution {

    public static function getIntersectionNode(ListNode $headA, ListNode $headB): ?int
    {
        if ($headA->next === null || $headB->next === null) {
            return null;
        }

        $hash = [];

        while ($headA !== null){
            $hash[json_encode($headA)] = $headA;
            $headA = $headA->next;
        }

        while ($headB !== null){
            if (isset($hash[json_encode($headB)])){
                return $headB->val;
            }
            $headB = $headB->next;
        }

        return null;
    }

    public static function fractionToDecimal(int $numerator, int $denominator)
    {
        if ($denominator === 0) return null;
        if ($numerator === 0) return 0;
        $result = ($numerator < 0 && $denominator < 0) ? '-' : '';
        $hash = [];
        $ceil = intdiv($numerator, $denominator);
        $numerator = $numerator % $denominator;
        $ceil .= ($numerator !== 0 ? '.' : '');
        $numerator *= 10;

        while ($numerator !== 0) {
            if (isset($hash[$numerator]))
            {
                $result = "({$result})";
                break;
            }
            $result .= intdiv($numerator, $denominator);
            $numerator = $numerator % $denominator;

            $hash[$numerator] = $result;
            $numerator *= 10;
        }

        return $ceil.$result;
    }
}