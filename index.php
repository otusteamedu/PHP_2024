<?php

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */


/**
 * сложность алгоритма O(n)
*/

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
        $slow = $head;
        $fast = $head;

        while( $slow && $fast && $slow->next ) {
            $slow = $slow->next;
            $fast = $fast->next->next;
            if($slow === $fast) {
                return true;
            }
        }

        return false;
    }
}

/**
 *
 * сложность алгоритма O(3n * 4m) - где m это цифры 7 и 9
 */
class SolutionTwo {

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {

        $len = strlen($digits);
        if( $len === 0 ){
            return [];
        }

        // Создаем словарь для соответствия цифр буквам на клавиатуре
        $digitsLettersMap = [
            '2' => 'abc',
            '3' => 'def',
            '4' => 'ghi',
            '5' => 'jkl',
            '6' => 'mno',
            '7' => 'pqrs',
            '8' => 'tuv',
            '9' => 'wxyz'
        ];

        $result = [];
        $this->backtrack($result, '', $digitsLettersMap, $digits, 0);
        return $result;
    }


    function backtrack(&$result, $combination, $digitsLettersMap, $digits, $index) {

        if ($index === strlen($digits)) {
            $result[] = $combination;
            return;
        }

        $current_digit = $digits[$index];
        $letters = str_split($digitsLettersMap[$current_digit]);
        foreach ($letters as $letter) {
            $this->backtrack($result, $combination . $letter, $digitsLettersMap, $digits, $index + 1);
        }
    }
}
