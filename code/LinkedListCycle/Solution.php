<?php

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution {
    /**
     * Проверяем связный ли лист обходя его всего один раз
     * Проверяя каждый шаг и следующий за ним одновременно
     * Сложность решения - О(n)
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle(ListNode $head): bool
    {
        $oneStep = $head;
        $twoSteps = $head;

        while ($oneStep && $oneStep->next){
            $oneStep = $oneStep->next;
            $twoSteps = $twoSteps->next->next;

            if($oneStep === $twoSteps){
                return true;
            }
        }
        return false;
    }
}