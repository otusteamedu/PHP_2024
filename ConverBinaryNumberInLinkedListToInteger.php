<?php

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val = 0, $next = null) {
 *         $this->val = $val;
 *         $this->next = $next;
 *     }
 * }
 */
class Solution {

    /**
     * @param ListNode $head
     * @return Integer
     */
    function getDecimalValue($head) {
        // базовый случай
        if ($head === null) {
            return 0;
        }

        // рекурсивный случай
        $bitPosition = $this->getDepth($head->next);
        return (2 ** $bitPosition) * $head->val + $this->getDecimalValue($head->next);
    }

    // вычисление длины списка
    function getDepth($head) {
        // базовый случай
        if ($head === null) {
            return 0;
        }

        // рекурсивный случай
        return $this->getDepth($head->next) + 1;
    }
}