<?php
declare(strict_types=1);


# Task 1 (https://leetcode.com/problems/intersection-of-two-linked-lists/)

/**
 * Definition for a singly-linked list.
 */
class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val,$next) {
        $this->val = $val;
        $this->next = $next;
    }
 }


class Solution {
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB) {
        if ($headA === null || $headB === null) {
            return null;
        }

        $a = $headA;
        $b = $headB;
        $count = 0;
        while ($a !== $b) {

            if ($a === null) {
                $a = $headB;
                $count++;
            }
            if ($b === null) {
                $b = $headA;
                $count++;
            }
            $a = $a->next;
            $b = $b->next;
            if ($count > 2) {
                return null;
            }
        }
        return $a;
    }
}

# Task 2 (https://leetcode.com/problems/fraction-to-recurring-decimal/description/)

/**
 * @param Integer $n
 * @param Integer $d
 * @return String
 */
function fractionToDecimal(int $n, int $d): string {

    if ($n === 0) {
        return '0';
    }

    $div = bcdiv((string)$n,(string)$d, 512);

    $divToArr = explode(".", (string)$div);
    $divAfterDot = $divToArr[1];
    $result = $divToArr[0];
    $match = '';
    $notMatch = '';

    $arr = str_split($divAfterDot);

    $str = $divAfterDot;
    for ($i = 0; $i < count($arr);$i++) {
        $str = substr($str,1);
        if (!str_contains($str, $arr[$i])) {
            $notMatch .= $arr[$i];
            continue;
        }
        $match .= $arr[$i];
        if ($arr[$i] === $arr[$i+1]) {
            if ($arr[$i] === $arr[$i+2] && $arr[$i] !== '0') {
                return $result.'.'.$notMatch.'('.$arr[$i].')';
            }
            continue;
        }

        if ($match === substr($str,0, strlen($match)) && $arr[$i] !== '0') {
            return $result.'.'.$notMatch.'('.$match.')';
        }
    }
    return ($notMatch? $result.'.'.$notMatch : $result) ;
}

echo fractionToDecimal(1,214748364);