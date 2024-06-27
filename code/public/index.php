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
    $div = [];
    $result = [];
    $div[] = $n/$d;
    $div[] = bcdiv((string)$n,(string)$d, 512);
    foreach ($div as $division) {
        $divToArr = explode(".", (string)$division);
        $divAfterDot = $divToArr[1];
        $match = '';
        $notMatch = '';

        $arr = str_split($divAfterDot);

        $str = $divAfterDot;
        $iMax = count($arr);
        $answer = 0;
        for ($i = 0; $i < $iMax; $i++) {

            $str = substr($str,1);
            if (!str_contains($str, $arr[$i])) {
                $notMatch .= $arr[$i];
                continue;
            }
            $match .= $arr[$i];

            if ($arr[$i] === $arr[$i+1] && $i+1 !== $iMax) {

                if ($arr[$i] === $arr[$i+2] && $arr[$i] !== '0' && $i+2 !== $iMax) {
                    $answer = 1;
                    $result[] = $divToArr[0].'.'.$notMatch.'('.$arr[$i].')';
                    break;
                }
                continue;
            }

            if (str_starts_with($str, $match) && $arr[$i] !== '0') {
                $answer = 1;
                $result[] = $divToArr[0].'.'.$notMatch.'('.$match.')';
                break;
            }
        }
        if ($answer === 0) {
            $result[] = $notMatch? $divToArr[0].'.'.$notMatch : $divToArr[0];
        }

    }

    return (rtrim($result[1],'0') === $result[0])? $result[0] : $result[1];
}

//echo fractionToDecimal(1,214748364);

function TESTfractionToDecimal(int $n, int $d): string
{
    if ($n === 0) {
        return '0';
    }
    $result = [];
    $div = bcdiv((string)$n, (string)$d, 8192);
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

        $matchStr.= $char;
        $matchCount = substr_count($strAfterDot,$matchStr);

        if ($matchCount > 1) {

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

//echo TESTfractionToDecimal(1,6);
//echo TESTfractionToDecimal(1,214748364);
//echo TESTfractionToDecimal(1,99);
//echo TESTfractionToDecimal(-1,-2147483648);
echo TESTfractionToDecimal(2147483647,370000);