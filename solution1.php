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
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
        while ($head->next !== null){
            if ($head->val === null) {
                return true;
            }

            $head->val = null;
            $head = $head->next;
        }

        return false;
    }
}