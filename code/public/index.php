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
        while (true) {
            if ($a === $b && $count !== 1) {
                return $a;
            }
            if ($a === null) {
                $a = $headB;
                $count++;
            } else $a = $a->next;

            if ($b === null) {
                $b = $headA;
                $count++;
            } else $b = $b->next;
            if ($count > 2) {
                return null;
            }
        }
    }
}


# Task 2 (https://leetcode.com/problems/fraction-to-recurring-decimal/description/)

/**
 * @param Integer $n
 * @param Integer $d
 * @return String
 */

function fractionToDecimal(int $n, int $d): string
{
    if ($n === 0) {
        return '0';
    }
    $result = [];
    $div = bcdiv((string)$n, (string)$d, 100000);
    $divToArr = explode(".", (string)$div);
    $strAfterDot = rtrim($divToArr[1],'0');
    $len = strlen($strAfterDot);
    $matchStr = '';
    $notMatch = '';
    if (!$strAfterDot) {
        return $divToArr[0];
    }
    $offset = 0;
    for ($i = 0; $i < $len; $i++) {
        $char = $strAfterDot[$i];
        if ($matchStr === '' && $char === '0') {
            $offset++;
            continue;
        }
        $matchStr.= $char;
        if ($offset) {
            for ($j = 0; $j < $offset; $offset--) {
                $matchStr = '0'.$matchStr;
                if (substr_count($strAfterDot,$matchStr) > 1) {
                    continue;
                }
                $notMatch = str_repeat('0',$offset);
                $offset = 0;
                $matchStr = substr($matchStr,1);
                break;
            }
        }

        $matchCount = substr_count($strAfterDot,$matchStr);

        if ($matchCount > 10) {

            if (str_replace($matchStr,'',$strAfterDot) === $notMatch) {
                return $divToArr[0].'.'.$notMatch.'('.$matchStr.')';
            }

            $result[$i] = [
                'key' => $matchCount,
                'value' => $matchStr
            ];
            if ((
                $result[$i-1]['key'] === ($result[$i]['key'] * 2) ||
                ($result[$i-1]['key'] + 1) === ($result[$i]['key'] * 2)
            )) {
                return $divToArr[0].'.'.$notMatch.'('.$result[$i-1]['value'].')';
            }
            continue;
        }
        $notMatch .= $char;
        $matchStr = substr($matchStr, 1);
    }
    if (empty($result)) {
        return $divToArr[0].'.'.$strAfterDot;
    }
    return $divToArr[0].'.'.$notMatch.$matchStr;
}
