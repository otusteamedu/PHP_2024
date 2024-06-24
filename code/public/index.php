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

    $div = $n/$d;

    if (!is_float($div)) {
        return (string)$div;
    }

    $divToArr = explode(".", (string)$div);
    $divAfterDot = $divToArr[1];
    $result = $divToArr[0];
    //$length = strlen($divAfterDot);
    $a = '';
    $match = '';
    $arr = str_split($divAfterDot);

    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] === $arr[$i+1]) {
            $match = $arr[$i];
            return $result.'.'.$a.'('.$match.')';
        } else {
            $a.= $arr[$i];
            if ($a[0] === $arr[$i]) {
                for ($j = 0; $j < strlen($a); $j++) {
                    if ($a[$j] === $arr[$i+$j]) {
                        $match .= $a[$j];
                        return $result.'.('.$match.')';
                    }
                }
            }
        }
    }
}

echo fractionToDecimal(1,6);